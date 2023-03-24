<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'allocation_id',
        'from',
        'to',
        'claimed_amount',
        'qty',
    ];

    protected $appends = ['total'];

    public function getTotalAttribute(): float
    {
        return $this->claimed_amount * $this->qty;
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function allocation(): BelongsTo
    {
        return $this->belongsTo(Allocation::class);
    }

    protected function claimedAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => (int) ($value * 100)
        );
    }
}
