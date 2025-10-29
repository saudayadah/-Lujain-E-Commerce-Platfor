<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ZATCAService
{
    public static function createInvoice(Order $order): Invoice
    {
        $sellerName = 'مؤسسة لُجين الزراعية';
        $vatNumber = '300000000000003';
        $crNumber = '1010000000';
        $sellerAddress = 'الرياض، المملكة العربية السعودية';
        $subtotal = $order->subtotal;
        $taxAmount = $order->tax;
        $discountAmount = $order->discount ?? 0;
        $shippingFee = $order->shipping_fee ?? 0;
        $totalAmount = $order->total;

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'name' => $item->product_name,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'subtotal' => $item->subtotal,
                'tax_rate' => 0.15,
                'tax_amount' => $item->subtotal * 0.15,
                'total' => $item->subtotal * 1.15,
            ];
        }

        $qrData = static::generateQRCodeData(
            $sellerName,
            $vatNumber,
            now()->toIso8601String(),
            $totalAmount,
            $taxAmount
        );

        $qrCodeImage = base64_encode(QrCode::format('png')->size(200)->generate($qrData));

        $invoice = Invoice::create([
            'order_id' => $order->id,
            'seller_name_ar' => $sellerName,
            'seller_name_en' => 'Lujain Agricultural Est.',
            'vat_number' => $vatNumber,
            'cr_number' => $crNumber,
            'seller_address' => $sellerAddress,
            'invoice_type' => 'simplified',
            'invoice_date' => now(),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'shipping_fee' => $shippingFee,
            'total_amount' => $totalAmount,
            'qr_code_data' => $qrData,
            'qr_code_image' => $qrCodeImage,
            'line_items' => $lineItems,
        ]);

        return $invoice;
    }

    public static function generateQRCodeData(
        string $sellerName,
        string $vatNumber,
        string $timestamp,
        float $totalAmount,
        float $taxAmount
    ): string {
        $tlvArray = [];
        $tlvArray[] = static::tlvEncode(1, $sellerName);
        $tlvArray[] = static::tlvEncode(2, $vatNumber);
        $tlvArray[] = static::tlvEncode(3, $timestamp);
        $tlvArray[] = static::tlvEncode(4, number_format($totalAmount, 2, '.', ''));
        $tlvArray[] = static::tlvEncode(5, number_format($taxAmount, 2, '.', ''));

        $tlvString = implode('', $tlvArray);
        return base64_encode($tlvString);
    }

    private static function tlvEncode(int $tag, string $value): string
    {
        $tagHex = pack('C', $tag);
        $lengthHex = pack('C', strlen($value));
        return $tagHex . $lengthHex . $value;
    }

    public static function tlvDecode(string $base64Data): array
    {
        $data = base64_decode($base64Data);
        $result = [];
        $offset = 0;

        while ($offset < strlen($data)) {
            $tag = unpack('C', substr($data, $offset, 1))[1];
            $offset++;

            $length = unpack('C', substr($data, $offset, 1))[1];
            $offset++;

            $value = substr($data, $offset, $length);
            $offset += $length;

            $result[$tag] = $value;
        }

        return $result;
    }

    public static function validateQRCode(string $base64Data): bool
    {
        try {
            $decoded = static::tlvDecode($base64Data);
            $requiredTags = [1, 2, 3, 4, 5];
            foreach ($requiredTags as $tag) {
                if (!isset($decoded[$tag])) {
                    return false;
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

