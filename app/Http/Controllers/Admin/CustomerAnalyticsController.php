<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CustomerSegmentService;
use App\Services\CampaignService;
use App\Models\User;
use App\Models\Order;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerAnalyticsController extends Controller
{
    protected CustomerSegmentService $segmentService;
    protected CampaignService $campaignService;

    public function __construct(
        CustomerSegmentService $segmentService,
        CampaignService $campaignService
    ) {
        $this->segmentService = $segmentService;
        $this->campaignService = $campaignService;
    }

    /**
     * لوحة التحليلات الرئيسية
     */
    public function index()
    {
        $stats = [
            'total_customers' => User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'average_order_value' => Order::where('payment_status', 'paid')->avg('total'),
            
            // شرائح العملاء
            'vip_customers' => $this->segmentService->getVIPCustomers()->count(),
            'active_customers' => $this->segmentService->getActiveCustomers()->count(),
            'inactive_customers' => $this->segmentService->getInactiveCustomers()->count(),
            'new_customers' => $this->segmentService->getNewCustomers()->count(),
            'repeat_customers' => $this->segmentService->getRepeatCustomers()->count(),
            'churn_risk_customers' => $this->segmentService->getChurnRiskCustomers()->count(),
        ];

        // أفضل العملاء (Top 10)
        $topCustomersData = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.payment_status', 'paid')
            ->select('users.id', DB::raw('COUNT(orders.id) as orders_count'), DB::raw('SUM(orders.total) as total_spent'))
            ->groupBy('users.id')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        $userIds = $topCustomersData->pluck('id');
        $topCustomers = User::whereIn('id', $userIds)
            ->get()
            ->map(function ($user) use ($topCustomersData) {
                $stats = $topCustomersData->firstWhere('id', $user->id);
                $user->orders_count = $stats->orders_count ?? 0;
                $user->total_spent = $stats->total_spent ?? 0;
                return $user;
            })
            ->sortByDesc('total_spent')
            ->values();

        // إحصائيات الحملات
        $campaignStats = [
            'total_campaigns' => Campaign::count(),
            'completed_campaigns' => Campaign::completed()->count(),
            'scheduled_campaigns' => Campaign::scheduled()->count(),
            'total_sent_messages' => Campaign::sum('sent_count'),
            'average_success_rate' => Campaign::completed()->avg('sent_count'),
        ];

        // آخر الحملات
        $recentCampaigns = Campaign::latest()->limit(5)->get();

        return view('admin.analytics.index', compact(
            'stats',
            'topCustomers',
            'campaignStats',
            'recentCampaigns'
        ));
    }

    /**
     * عرض شريحة محددة من العملاء
     */
    public function segment(Request $request, string $segmentType)
    {
        $customers = match ($segmentType) {
            'vip' => $this->segmentService->getVIPCustomers(),
            'active' => $this->segmentService->getActiveCustomers(),
            'inactive' => $this->segmentService->getInactiveCustomers(),
            'new' => $this->segmentService->getNewCustomers(),
            'repeat' => $this->segmentService->getRepeatCustomers(),
            'churn_risk' => $this->segmentService->getChurnRiskCustomers(),
            default => collect([]),
        };

        // حساب إحصائيات الشريحة
        $segmentStats = [
            'count' => $customers->count(),
            'total_revenue' => $customers->sum(fn($c) => $c->orders()->where('payment_status', 'paid')->sum('total')),
            'average_orders' => $customers->avg(fn($c) => $c->orders()->where('payment_status', 'paid')->count()),
        ];

        return view('admin.analytics.segment', compact('customers', 'segmentType', 'segmentStats'));
    }

    /**
     * تحليل تفصيلي لعميل محدد
     */
    public function customerDetails(User $customer)
    {
        $analytics = $this->segmentService->getCustomerAnalytics($customer);
        $orders = $customer->orders()->with('items.product')->latest()->paginate(10);

        return view('admin.analytics.customer-details', compact('customer', 'analytics', 'orders'));
    }

    /**
     * صفحة إنشاء حملة جديدة
     */
    public function createCampaign()
    {
        $segments = [
            'vip' => 'عملاء VIP',
            'active' => 'عملاء نشطين',
            'inactive' => 'عملاء خاملين',
            'new' => 'عملاء جدد',
            'repeat' => 'عملاء متكررين',
            'churn_risk' => 'عملاء معرضين للمغادرة',
            'all' => 'جميع العملاء',
        ];

        return view('admin.campaigns.create', compact('segments'));
    }

    /**
     * إرسال حملة
     */
    public function sendCampaign(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'segment' => 'required|string',
            'message' => 'required|string',
            'channels' => 'required|array',
            'channels.*' => 'in:whatsapp,sms,email',
        ]);

        // الحصول على العملاء المستهدفين
        $customers = match ($request->segment) {
            'vip' => $this->segmentService->getVIPCustomers(),
            'active' => $this->segmentService->getActiveCustomers(),
            'inactive' => $this->segmentService->getInactiveCustomers(),
            'new' => $this->segmentService->getNewCustomers(),
            'repeat' => $this->segmentService->getRepeatCustomers(),
            'churn_risk' => $this->segmentService->getChurnRiskCustomers(),
            'all' => User::whereHas('orders')->get(),
            default => collect([]),
        };

        if ($customers->isEmpty()) {
            return back()->with('error', 'لا يوجد عملاء في هذه الشريحة');
        }

        // إرسال الحملة
        $results = $this->campaignService->sendCampaign(
            $customers,
            $request->message,
            $request->channels,
            [
                'campaign_name' => $request->name,
                'segment' => $request->segment,
            ]
        );

        return redirect()->route('admin.campaigns.index')
            ->with('success', "تم إرسال الحملة بنجاح! أرسلت: {$results['sent']} | فشلت: {$results['failed']}");
    }

    /**
     * عرض جميع الحملات
     */
    public function campaigns()
    {
        $campaigns = Campaign::latest()->paginate(20);
        
        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * تفاصيل حملة محددة
     */
    public function campaignDetails(Campaign $campaign)
    {
        return view('admin.campaigns.details', compact('campaign'));
    }

    /**
     * إرسال حملة سريعة (Quick Campaign)
     */
    public function quickCampaign(Request $request)
    {
        $request->validate([
            'type' => 'required|in:promotional,welcome,winback,vip',
            'segment' => 'required|string',
        ]);

        $customers = match ($request->segment) {
            'vip' => $this->segmentService->getVIPCustomers(),
            'active' => $this->segmentService->getActiveCustomers(),
            'inactive' => $this->segmentService->getInactiveCustomers(),
            'new' => $this->segmentService->getNewCustomers(),
            default => collect([]),
        };

        $results = match ($request->type) {
            'welcome' => $this->campaignService->sendWelcomeCampaign($customers),
            'winback' => $this->campaignService->sendWinBackCampaign($customers, 15),
            'vip' => $this->campaignService->sendVIPCampaign($customers, 'خصم 20% على جميع المنتجات'),
            'promotional' => $this->campaignService->sendPromotionalCampaign(
                $customers,
                $request->input('product_name', 'منتجاتنا المميزة'),
                $request->input('discount', 10),
                $request->input('coupon_code', 'SPECIAL10')
            ),
        };

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الحملة بنجاح',
            'results' => $results,
        ]);
    }

    /**
     * تصدير بيانات العملاء
     */
    public function exportCustomers(Request $request, string $segmentType)
    {
        $customers = match ($segmentType) {
            'vip' => $this->segmentService->getVIPCustomers(),
            'active' => $this->segmentService->getActiveCustomers(),
            'inactive' => $this->segmentService->getInactiveCustomers(),
            'new' => $this->segmentService->getNewCustomers(),
            'repeat' => $this->segmentService->getRepeatCustomers(),
            'churn_risk' => $this->segmentService->getChurnRiskCustomers(),
            default => User::whereHas('orders')->get(),
        };

        $data = $customers->map(function ($customer) {
            return [
                'الاسم' => $customer->name,
                'البريد الإلكتروني' => $customer->email,
                'الهاتف' => $customer->phone,
                'عدد الطلبات' => $customer->orders()->count(),
                'إجمالي الإنفاق' => $customer->orders()->where('payment_status', 'paid')->sum('total'),
                'آخر طلب' => $customer->orders()->latest()->first()?->created_at?->format('Y-m-d'),
            ];
        });

        return response()->streamDownload(function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, array_keys($data->first()));
            
            // Data
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        }, "customers-{$segmentType}-" . now()->format('Y-m-d') . ".csv");
    }
}

