<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>فاتورة - {{ $invoice->invoice_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');
        
        * {
            font-family: 'DejaVu Sans', 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            padding: 30px;
            font-size: 13px;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 4px solid #10b981;
            padding-bottom: 25px;
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 8px;
        }
        
        .company-name-en {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 15px;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            color: #1f2937;
        }
        
        .invoice-subtitle {
            font-size: 14px;
            color: #6b7280;
        }
        
        .info-box {
            border: 2px solid #e5e7eb;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            background: #f9fafb;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .label {
            font-weight: bold;
            color: #4b5563;
        }
        
        .value {
            color: #1f2937;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }
        
        th {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px;
            text-align: right;
            font-weight: bold;
            border: none;
        }
        
        td {
            padding: 12px;
            border: 1px solid #e5e7eb;
            text-align: right;
        }
        
        tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .total-section {
            margin-top: 30px;
            float: left;
            width: 50%;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            margin: 5px 0;
            background: #f9fafb;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .grand-total {
            font-size: 20px;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
            padding: 15px 20px;
            margin-top: 15px;
        }
        
        .qr-code {
            text-align: center;
            margin: 40px 0;
            clear: both;
        }
        
        .qr-code img {
            width: 180px;
            height: 180px;
            border: 3px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px;
        }
        
        .qr-text {
            margin-top: 15px;
            font-size: 12px;
            color: #6b7280;
        }
        
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 25px;
            border-top: 3px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        
        .footer p {
            margin: 8px 0;
        }
        
        .thank-you {
            font-size: 16px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">🌿 مؤسسة لُجَـيِّـن الزراعية</div>
        <div class="company-name-en">Lujain Agricultural Establishment</div>
        <div class="invoice-title">فاتورة ضريبية مبسطة</div>
        <div class="invoice-subtitle">Simplified Tax Invoice</div>
    </div>

    <!-- Seller Information -->
    <div class="info-box">
        <div class="info-row">
            <span class="label">الرقم الضريبي / VAT Number:</span>
            <span class="value">{{ $invoice->vat_number }}</span>
        </div>
        <div class="info-row">
            <span class="label">رقم السجل التجاري / CR Number:</span>
            <span class="value">{{ $invoice->cr_number }}</span>
        </div>
        <div class="info-row">
            <span class="label">العنوان / Address:</span>
            <span class="value">{{ $invoice->seller_address }}</span>
        </div>
    </div>

    <!-- Invoice Details -->
    <div class="info-box">
        <div class="info-row">
            <span class="label">رقم الفاتورة / Invoice Number:</span>
            <span class="value">{{ $invoice->invoice_number }}</span>
        </div>
        <div class="info-row">
            <span class="label">التاريخ / Date:</span>
            <span class="value">{{ $invoice->invoice_date->format('Y-m-d') }}</span>
        </div>
        <div class="info-row">
            <span class="label">الوقت / Time:</span>
            <span class="value">{{ $invoice->invoice_date->format('h:i A') }}</span>
        </div>
        <div class="info-row">
            <span class="label">UUID:</span>
            <span class="value" style="font-size: 10px;">{{ $invoice->uuid }}</span>
        </div>
    </div>

    <!-- Line Items -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 40%;">المنتج / Product</th>
                <th style="width: 15%;">الكمية / Qty</th>
                <th style="width: 20%;">السعر / Price</th>
                <th style="width: 20%;">الإجمالي / Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->line_items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['unit_price'], 2) }} ر.س</td>
                <td>{{ number_format($item['subtotal'], 2) }} ر.س</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="total-section">
        <div class="total-row">
            <span>المجموع قبل الضريبة:</span>
            <span>{{ number_format($invoice->subtotal, 2) }} ر.س</span>
        </div>
        
        @if($invoice->discount_amount > 0)
        <div class="total-row">
            <span>الخصم / Discount:</span>
            <span style="color: #dc2626;">- {{ number_format($invoice->discount_amount, 2) }} ر.س</span>
        </div>
        @endif
        
        @if($invoice->shipping_fee > 0)
        <div class="total-row">
            <span>رسوم الشحن / Shipping:</span>
            <span>{{ number_format($invoice->shipping_fee, 2) }} ر.س</span>
        </div>
        @endif
        
        <div class="total-row">
            <span>ضريبة القيمة المضافة (15%):</span>
            <span>{{ number_format($invoice->tax_amount, 2) }} ر.س</span>
        </div>
        
        <div class="total-row grand-total">
            <span>الإجمالي النهائي:</span>
            <span>{{ number_format($invoice->total_amount, 2) }} ر.س</span>
        </div>
    </div>

    <!-- QR Code -->
    <div class="qr-code">
        <img src="data:image/png;base64,{{ $invoice->qr_code_image }}" alt="QR Code">
        <div class="qr-text">
            <strong>امسح الرمز للتحقق من الفاتورة</strong><br>
            Scan QR Code to Verify Invoice
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p class="thank-you">✨ شكراً لتعاملكم معنا ✨</p>
        <p class="thank-you">Thank You for Your Business</p>
        <p style="margin-top: 20px;">مؤسسة لُجين الزراعية - Lujain Agricultural Establishment</p>
        <p>للاستفسارات: info@lujain.sa | جوال: +966 50 000 0000</p>
        <p style="margin-top: 15px; font-size: 10px;">تم إنشاء هذه الفاتورة إلكترونياً وهي صالحة بدون ختم أو توقيع</p>
        <p style="font-size: 10px;">This invoice was generated electronically and is valid without stamp or signature</p>
    </div>
</body>
</html>

