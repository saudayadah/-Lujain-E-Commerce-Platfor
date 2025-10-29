<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

/**
 * خدمة إنشاء الفواتير الاحترافية
 * مع دعم فاتورة ZATCA الإلكترونية
 */
class InvoiceService
{
    protected ZATCAService $zatcaService;

    public function __construct(ZATCAService $zatcaService)
    {
        $this->zatcaService = $zatcaService;
    }

    /**
     * إنشاء فاتورة احترافية للطلب
     */
    public function generateInvoice(Order $order): Invoice
    {
        // التحقق من وجود فاتورة سابقة
        $existingInvoice = $order->invoice;
        if ($existingInvoice && $existingInvoice->status !== 'cancelled') {
            return $existingInvoice;
        }

        // إنشاء فاتورة جديدة
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'issue_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => $order->subtotal,
            'tax_amount' => $order->tax,
            'shipping_amount' => $order->shipping_fee,
            'discount_amount' => $order->discount,
            'total_amount' => $order->total,
            'currency' => 'SAR',
            'status' => 'issued',
        ]);

        // إنشاء ملف PDF
        $pdfPath = $this->generatePDF($invoice);

        // تحديث مسار PDF
        $invoice->update([
            'pdf_path' => $pdfPath,
            'issued_at' => now(),
        ]);

        // إرسال فاتورة ZATCA إذا مفعل
        if (config('zatca.enabled', false)) {
            $this->processZATCAInvoice($invoice);
        }

        return $invoice->fresh();
    }

    /**
     * توليد رقم الفاتورة
     */
    protected function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . date('Y');
        $lastInvoice = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = intval(substr($lastInvoice->invoice_number, -6));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * إنشاء ملف PDF احترافي
     */
    protected function generatePDF(Invoice $invoice): string
    {
        $order = $invoice->order;
        $data = [
            'invoice' => $invoice,
            'order' => $order,
            'customer' => $order->user,
            'items' => $order->items,
            'company' => $this->getCompanyInfo(),
        ];

        // توليد PDF باللغة العربية مع دعم RTL
        $pdf = Pdf::loadView('invoices.professional', $data, [], [
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'portrait',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
        ]);

        // حفظ الملف
        $filename = "invoice_{$invoice->invoice_number}.pdf";
        $path = "invoices/{$filename}";

        Storage::put($path, $pdf->output());

        return $path;
    }

    /**
     * معالجة فاتورة ZATCA
     */
    protected function processZATCAInvoice(Invoice $invoice): void
    {
        try {
            // توليد XML للفاتورة
            $zatcaData = $this->generateZATCAXML($invoice);

            // إرسال إلى ZATCA
            $zatcaResponse = $this->zatcaService->submitInvoice($zatcaData);

            if ($zatcaResponse['success']) {
                $invoice->update([
                    'zatca_status' => 'submitted',
                    'zatca_uuid' => $zatcaResponse['uuid'],
                    'zatca_qr_code' => $zatcaResponse['qr_code'],
                    'zatca_submission_date' => now(),
                ]);
            } else {
                $invoice->update([
                    'zatca_status' => 'failed',
                    'zatca_error' => $zatcaResponse['error'],
                ]);
            }
        } catch (\Exception $e) {
            $invoice->update([
                'zatca_status' => 'error',
                'zatca_error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * توليد XML لفاتورة ZATCA
     */
    protected function generateZATCAXML(Invoice $invoice): array
    {
        $order = $invoice->order;

        return [
            'invoice_number' => $invoice->invoice_number,
            'issue_date' => $invoice->issue_date->format('Y-m-d'),
            'seller_name' => config('zatca.company_name_ar', 'لُجين الزراعية'),
            'seller_vat_number' => config('zatca.vat_number', ''),
            'customer_name' => $order->user->name,
            'total_amount' => $invoice->total_amount,
            'tax_amount' => $invoice->tax_amount,
            'items' => $order->items->map(function ($item) {
                return [
                    'name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total_price' => $item->subtotal,
                ];
            })->toArray(),
        ];
    }

    /**
     * الحصول على معلومات الشركة
     */
    protected function getCompanyInfo(): array
    {
        return [
            'name_ar' => config('zatca.company_name_ar', 'لُجين الزراعية'),
            'name_en' => config('zatca.company_name_en', 'Lujain Agricultural'),
            'vat_number' => config('zatca.vat_number', ''),
            'address_ar' => $this->buildCompanyAddress('ar'),
            'address_en' => $this->buildCompanyAddress('en'),
            'phone' => config('app.phone', ''),
            'email' => config('app.email', ''),
            'website' => config('app.url', ''),
        ];
    }

    /**
     * بناء عنوان الشركة
     */
    protected function buildCompanyAddress(string $lang): string
    {
        $address = [];

        if ($building = config("zatca.building_number")) {
            $address[] = $lang === 'ar' ? "مبنى {$building}" : "Building {$building}";
        }

        if ($street = config("zatca.street_" . $lang)) {
            $address[] = $street;
        }

        if ($district = config("zatca.district_" . $lang)) {
            $address[] = $district;
        }

        if ($city = config("zatca.city_" . $lang)) {
            $address[] = $city;
        }

        if ($postal = config("zatca.postal_code")) {
            $address[] = $postal;
        }

        return implode(', ', $address);
    }

    /**
     * إرسال الفاتورة عبر البريد الإلكتروني
     */
    public function sendInvoiceEmail(Invoice $invoice): bool
    {
        try {
            $invoice->order->user->notify(new \App\Notifications\InvoiceGeneratedNotification($invoice));
            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to send invoice email: " . $e->getMessage());
            return false;
        }
    }

    /**
     * إعادة إرسال الفاتورة
     */
    public function resendInvoice(Invoice $invoice): bool
    {
        // إعادة إنشاء PDF إذا لزم الأمر
        if (!$invoice->pdf_path || !Storage::exists($invoice->pdf_path)) {
            $this->generatePDF($invoice);
        }

        return $this->sendInvoiceEmail($invoice);
    }

    /**
     * إلغاء الفاتورة
     */
    public function cancelInvoice(Invoice $invoice, string $reason = ''): bool
    {
        try {
            $invoice->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ]);

            // إشعار العميل بالإلغاء
            $invoice->order->user->notify(new \App\Notifications\InvoiceCancelledNotification($invoice, $reason));

            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to cancel invoice: " . $e->getMessage());
            return false;
        }
    }
}

