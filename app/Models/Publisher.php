<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Scope methods of the model
    public function scopeFoundedYearBetween(Builder $builder, $start, $end): Builder
    {
        return $builder->whereBetween('founded_year', [$start, $end]);
    }

    public function scopeFoundedYear(Builder $builder, $year): Builder
    {
        return $builder->where('founded_year', $year);
    }
}
