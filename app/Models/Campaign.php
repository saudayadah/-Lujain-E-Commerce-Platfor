<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'segment_type',
        'segment_conditions',
        'message',
        'channels',
        'template_id',
        'total_recipients',
        'sent_count',
        'failed_count',
        'delivered_count',
        'opened_count',
        'clicked_count',
        'converted_count',
        'unsubscribed_count',
        'bounced_count',
        'status',
        'scheduled_at',
        'sent_at',
        'completed_at',
        'results',
        'settings',
        'created_by',
    ];

    protected $casts = [
        'segment_conditions' => 'array',
        'channels' => 'array',
        'results' => 'array',
        'settings' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // علاقة مع العملاء المستهدفين
    public function targetCustomers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_customers')
                    ->withPivot(['sent_at', 'delivered_at', 'opened_at', 'clicked_at', 'converted_at', 'status'])
                    ->withTimestamps();
    }

    // علاقة مع العملاء الذين تفاعلوا
    public function interactedCustomers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_customers')
                    ->wherePivotIn('status', ['delivered', 'opened', 'clicked', 'converted']);
    }

    // علاقة مع العملاء الذين تحولوا
    public function convertedCustomers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_customers')
                    ->wherePivot('status', 'converted');
    }

    // علاقة مع منشئ الحملة
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'scheduled', 'sending']);
    }

    public function getSuccessRateAttribute(): float
    {
        if ($this->sent_count == 0) {
            return 0;
        }

        return ($this->delivered_count / $this->sent_count) * 100;
    }

    public function getOpenRateAttribute(): float
    {
        if ($this->delivered_count == 0) {
            return 0;
        }

        return ($this->opened_count / $this->delivered_count) * 100;
    }

    public function getClickRateAttribute(): float
    {
        if ($this->opened_count == 0) {
            return 0;
        }

        return ($this->clicked_count / $this->opened_count) * 100;
    }

    public function getConversionRateAttribute(): float
    {
        if ($this->delivered_count == 0) {
            return 0;
        }

        return ($this->converted_count / $this->delivered_count) * 100;
    }

    public function getRoiAttribute(): float
    {
        if ($this->converted_count == 0) {
            return 0;
        }

        // حساب العائد بناءً على المتوسط المقدر لقيمة التحويل
        $avgConversionValue = 150; // يمكن تخصيصه حسب المنتج
        $totalRevenue = $this->converted_count * $avgConversionValue;
        $campaignCost = $this->settings['cost'] ?? 0;

        return $campaignCost > 0 ? (($totalRevenue - $campaignCost) / $campaignCost) * 100 : 0;
    }
}

