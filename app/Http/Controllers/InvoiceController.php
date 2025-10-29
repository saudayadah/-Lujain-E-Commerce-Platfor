<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        if ($invoice->order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح بعرض هذه الفاتورة');
        }

        return view('invoices.show', compact('invoice'));
    }

    public function pdf(Invoice $invoice)
    {
        if ($invoice->order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح بعرض هذه الفاتورة');
        }

        return $invoice->viewPDF();
    }

    public function download(Invoice $invoice)
    {
        if ($invoice->order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح بتحميل هذه الفاتورة');
        }

        return $invoice->downloadPDF();
    }
}

