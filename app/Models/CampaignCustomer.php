<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignCustomer extends Pivot
{
    use HasFactory;

    protected $table = 'campaign_customers';

    protected $fillable = [
        'campaign_id',
        'user_id',
        'status',
        'sent_at',
        'delivered_at',
        'opened_at',
        'clicked_at',
        'converted_at',
        'bounced_at',
        'unsubscribed_at',
        'error_message',
        'delivery_attempts',
        'last_attempt_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'converted_at' => 'datetime',
        'bounced_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'last_attempt_at' => 'datetime',
    ];

    // علاقة مع الحملة
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    // علاقة مع العميل
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes للبحث حسب الحالة
    public function scopeSent($query)
    {
        return $query->whereNotNull('sent_at');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeOpened($query)
    {
        return $query->where('status', 'opened');
    }

    public function scopeClicked($query)
    {
        return $query->where('status', 'clicked');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    public function scopeBounced($query)
    {
        return $query->where('status', 'bounced');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // تحديث حالة التفاعل
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'last_attempt_at' => now(),
            'delivery_attempts' => $this->delivery_attempts + 1,
        ]);
    }

    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    public function markAsOpened(): void
    {
        $this->update([
            'status' => 'opened',
            'opened_at' => now(),
        ]);
    }

    public function markAsClicked(): void
    {
        $this->update([
            'status' => 'clicked',
            'clicked_at' => now(),
        ]);
    }

    public function markAsConverted(): void
    {
        $this->update([
            'status' => 'converted',
            'converted_at' => now(),
        ]);
    }

    public function markAsBounced(string $error = null): void
    {
        $this->update([
            'status' => 'bounced',
            'bounced_at' => now(),
            'error_message' => $error,
        ]);
    }

    public function markAsFailed(string $error = null): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $error,
            'last_attempt_at' => now(),
            'delivery_attempts' => $this->delivery_attempts + 1,
        ]);
    }

    public function markAsUnsubscribed(): void
    {
        $this->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
    }

    // التحقق من إمكانية إعادة المحاولة
    public function canRetry(): bool
    {
        return $this->delivery_attempts < 3 &&
               $this->last_attempt_at &&
               $this->last_attempt_at->diffInMinutes(now()) >= 5;
    }

    // التحقق من حالة التفاعل
    public function isDelivered(): bool
    {
        return $this->status === 'delivered' && $this->delivered_at;
    }

    public function isOpened(): bool
    {
        return $this->status === 'opened' && $this->opened_at;
    }

    public function isClicked(): bool
    {
        return $this->status === 'clicked' && $this->clicked_at;
    }

    public function isConverted(): bool
    {
        return $this->status === 'converted' && $this->converted_at;
    }
}
