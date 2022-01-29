<?php

namespace App\Models;

use App\Enums\ComicFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comic extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'format' => ComicFormat::class,
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }
}
