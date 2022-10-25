<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use HasFactory, SoftDeletes;

    const APPROVAL_PEDNGING = 1;
    const APPROVAL_APPROVED = 2;
    const APPROVAL_REJECTED = 3;

    protected $casts
        = [
            'lat' => 'decimal:11',
            'lng' => 'decimal:11',
            'price_per_day' => 'decimal:2',
            'monthly_discount' => 'decimal:2',
            'approval_status' => 'integer',
            'hidden' => 'boolean',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);

    }

    public function images()
    {
        return $this->morphMany(Image::class, 'resource');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeNearestTo(Builder $builder, $lat, $lng)
    {
        return $builder->selectRaw(
            'SQRT(POW(69.1 * (lat - ?), 2) + POW(69.1 * (? - lng) * COS(lat / 57.3), 2)) AS distance',
            [$lat, $lng])->orderBy('distance');
    }
}
