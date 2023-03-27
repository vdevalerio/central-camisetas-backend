<?php

namespace App\Models;

use App\Enums\ProductCollar;
use App\Enums\ProductCuff;
use App\Enums\ProductFaixa;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const COLLAR = [
        ProductCollar::BIAS,
        ProductCollar::CUFF,
        ProductCollar::POLO,
        ProductCollar::SELECTION,
        ProductCollar::V,
    ];

    const CUFF = [
        ProductCuff::YES,
        ProductCuff::NO,
        ProductCuff::ANOTHER_COLOR,
        ProductCuff::BIAS,
    ];

    const FAIXA = [
        ProductFaixa::YES,
        ProductFaixa::NO,
        ProductFaixa::ANOTHER_COLOR,
    ];

    const TYPES = [
        ProductType::T_SHIRTS,
        ProductType::SHORTS,
        ProductType::PANTS,
        ProductType::SHORTS_SKIRTS,
    ];

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

    public function getCollarFormattedAttribute()
    {
        return self::COLLAR[$this->attributes['collar'] - 1];
    }

    public function getCuffFormattedAttribute()
    {
        return self::CUFF[$this->attributes['cuff'] - 1];
    }

    public function getFaixaFormattedAttribute()
    {
        return self::FAIXA[$this->attributes['faixa'] - 1];
    }

    public function getTypeFormattedAttribute()
    {
        return self::TYPES[$this->attributes['type'] - 1];
    }
}