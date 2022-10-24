<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'price_per_day' => 'decimal',
        'monthly_discount' => 'decimal',
        'approval_status' => 'integer',
        'hidden' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'resource');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
