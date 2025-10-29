<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'uuid',
        'seller_name_ar',
        'seller_name_en',
        'vat_number',
        'cr_number',
        'seller_address',
        'invoice_type',
        'invoice_date',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'shipping_fee',
        'total_amount',
        'qr_code_data',
        'qr_code_image',
        'line_items',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'line_items' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($invoice) {
            if (empty($invoice->uuid)) {
                $invoice->uuid = (string) Str::uuid();
            }
            
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = static::generateInvoiceNumber();
            }
            
            if (empty($invoice->invoice_date)) {
                $invoice->invoice_date = now();
            }
        });
    }

    public static function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now()->format('Y-m-d'))->count() + 1;
        return 'INV-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function downloadPDF()
    {
        $pdf = \PDF::loadView('invoices.pdf', ['invoice' => $this]);
        return $pdf->download('invoice-' . $this->invoice_number . '.pdf');
    }

    public function viewPDF()
    {
        $pdf = \PDF::loadView('invoices.pdf', ['invoice' => $this]);
        return $pdf->stream();
    }
}
