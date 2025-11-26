<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => QuoteStatus::class,
        'customer_details' => 'array',
        'issuer_details' => 'array',
        'items' => 'array',
        'quote_date' => 'date',
        'due_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function convertedInvoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'converted_to_invoice_id');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', QuoteStatus::PENDING);
    }

    public function scopeConverted(Builder $query): Builder
    {
        return $query->where('status', QuoteStatus::CONVERTED);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $quote) {
            $quote->calculateTotals();
            // We'll need a service to generate quote numbers, similar to invoices
            // For now, let's assume we'll handle it in the controller or service
        });
        
        static::updating(function (self $quote) {
            $quote->calculateTotals();
        });
    }

    public function calculateTotals()
    {
        $items = collect($this->items)->map(function ($item) {
            $item['total'] = $item['rate'] * $item['quantity'];
            return $item;
        });

        $this->items = $items;
        $this->total = $items->sum('total');
    }

    public function getRouteKeyName()
    {
        return 'quote_number';
    }
}
