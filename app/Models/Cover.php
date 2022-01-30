<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cover extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function comic(): BelongsTo
    {
        return $this->belongsTo(Comic::class);
    }
}
