<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['order.user'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->paginate(20);

        // Statistics
        $stats = [
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'total_transactions' => Payment::count(),
            'successful_payments' => Payment::where('status', 'completed')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'today_revenue' => Payment::where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('amount'),
            'this_month_revenue' => Payment::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
        ];

        // Payment methods distribution
        $paymentMethods = Payment::select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->where('status', 'completed')
            ->groupBy('payment_method')
            ->get();

        return view('admin.payments.index', compact('payments', 'stats', 'paymentMethods'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['order.user', 'order.items.product']);

        return view('admin.payments.show', compact('payment'));
    }

    public function refund(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $payment->amount,
            'reason' => 'required|string|max:500',
        ]);

        try {
            // Here you would call Moyasar refund API
            // For now, we'll just update the status
            
            $payment->update([
                'status' => 'refunded',
                'refund_amount' => $request->amount,
                'refund_reason' => $request->reason,
                'refunded_at' => now(),
            ]);

            $payment->order->update([
                'payment_status' => 'refunded',
                'status' => 'refunded',
            ]);

            return back()->with('success', 'تم استرجاع المبلغ بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'فشل في استرجاع المبلغ: ' . $e->getMessage());
        }
    }

    public function dashboard()
    {
        // Revenue by day (last 30 days)
        $revenueByDay = Payment::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by month (current year)
        $revenueByMonth = Payment::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Payment methods stats
        $paymentMethodsStats = Payment::where('status', 'completed')
            ->select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        // Success rate
        $totalPayments = Payment::count();
        $successfulPayments = Payment::where('status', 'completed')->count();
        $successRate = $totalPayments > 0 ? ($successfulPayments / $totalPayments) * 100 : 0;

        // Recent failed payments
        $failedPayments = Payment::where('status', 'failed')
            ->with(['order.user'])
            ->latest()
            ->take(10)
            ->get();

        // Top customers by payment
        $topCustomers = Payment::where('status', 'completed')
            ->select('order_id', DB::raw('SUM(amount) as total_spent'))
            ->groupBy('order_id')
            ->orderByDesc('total_spent')
            ->take(10)
            ->with('order.user')
            ->get();

        $stats = [
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'today_revenue' => Payment::where('status', 'completed')->whereDate('created_at', today())->sum('amount'),
            'this_week_revenue' => Payment::where('status', 'completed')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount'),
            'this_month_revenue' => Payment::where('status', 'completed')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('amount'),
            'total_transactions' => Payment::count(),
            'successful_payments' => $successfulPayments,
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'refunded_payments' => Payment::where('status', 'refunded')->count(),
            'success_rate' => round($successRate, 2),
            'avg_transaction_value' => $successfulPayments > 0 ? Payment::where('status', 'completed')->avg('amount') : 0,
        ];

        return view('admin.payments.dashboard', compact(
            'stats',
            'revenueByDay',
            'revenueByMonth',
            'paymentMethodsStats',
            'failedPayments',
            'topCustomers'
        ));
    }

    public function reports(Request $request)
    {
        $period = $request->get('period', 'month'); // day, week, month, year
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        $payments = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['order.user'])
            ->get();

        $report = [
            'total_revenue' => $payments->sum('amount'),
            'total_transactions' => $payments->count(),
            'avg_transaction_value' => $payments->avg('amount'),
            'by_payment_method' => $payments->groupBy('payment_method')->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'total' => $items->sum('amount'),
                ];
            }),
            'by_date' => $payments->groupBy(function ($payment) use ($period) {
                switch ($period) {
                    case 'day':
                        return $payment->created_at->format('Y-m-d H:00');
                    case 'week':
                        return $payment->created_at->format('Y-W');
                    case 'year':
                        return $payment->created_at->format('Y-m');
                    default: // month
                        return $payment->created_at->format('Y-m-d');
                }
            })->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'total' => $items->sum('amount'),
                ];
            }),
        ];

        return view('admin.payments.reports', compact('report', 'period', 'startDate', 'endDate', 'payments'));
    }

    public function export(Request $request)
    {
        // Export payments to Excel/CSV
        // This would use Maatwebsite Excel package
        // For now, just return a download response
        
        $payments = Payment::with(['order.user'])
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->get();

        // Generate CSV
        $csv = "رقم المعاملة,رقم الطلب,العميل,المبلغ,طريقة الدفع,الحالة,التاريخ\n";
        
        foreach ($payments as $payment) {
            $csv .= sprintf(
                "%s,%s,%s,%.2f,%s,%s,%s\n",
                $payment->transaction_id,
                $payment->order->order_number,
                $payment->order->user->name ?? 'ضيف',
                $payment->amount,
                $this->getPaymentMethodName($payment->payment_method),
                $this->getStatusName($payment->status),
                $payment->created_at->format('Y-m-d H:i:s')
            );
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="payments_' . date('Y-m-d') . '.csv"',
        ]);
    }

    private function getPaymentMethodName($method)
    {
        return match ($method) {
            'cod' => 'الدفع عند الاستلام',
            'moyasar' => 'ميسر',
            'creditcard' => 'بطاقة ائتمانية',
            'applepay' => 'Apple Pay',
            default => $method,
        };
    }

    private function getStatusName($status)
    {
        return match ($status) {
            'completed' => 'مكتمل',
            'pending' => 'معلق',
            'failed' => 'فاشل',
            'refunded' => 'مسترجع',
            default => $status,
        };
    }
}
