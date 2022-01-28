<?php

namespace App\Models;

use App\Enums\SeriesTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => SeriesTypes::class,
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function comics(): HasMany
    {
        return $this->hasMany(Comic::class);
    }
}
