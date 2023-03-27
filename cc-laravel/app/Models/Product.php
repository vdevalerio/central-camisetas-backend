<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'size',
        'type',
        'model',
        'tissue',
        'color',
        'pocket',
        'collar',
        'cuff',
        'vivo',
        'faixa',
    ];

    public function scopePriceBetween(Builder $query, $range)
    {
        return $query->whereBetween('price', $range);
    }
}