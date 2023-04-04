<?php

namespace App\Models;

use App\Enums\ProductCollar;
use App\Enums\ProductCuff;
use App\Enums\ProductFaixa;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $size
 * @property string $type
 * @property string $model
 * @property string $tissue
 * @property string $color
 * @property int $pocket
 * @property string|null $collar
 * @property string|null $cuff
 * @property int|null $vivo
 * @property string|null $faixa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $collar_formatted
 * @property-read mixed $cuff_formatted
 * @property-read mixed $faixa_formatted
 * @property-read mixed $type_formatted
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product priceBetween($range)
 * @method static Builder|Product query()
 * @method static Builder|Product whereCollar($value)
 * @method static Builder|Product whereColor($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereCuff($value)
 * @method static Builder|Product whereFaixa($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereModel($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePocket($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereSize($value)
 * @method static Builder|Product whereTissue($value)
 * @method static Builder|Product whereType($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereVivo($value)
 * @mixin \Eloquent
 */
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

    public function getAllowedFilters()
    {
        return [
            'id',
            'name',
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
            AllowedFilter::scope('price_between'),
        ];
    }

    public function getAllowedSorts()
    {
        return [
            'id',
            'name',
            'size',
            'price',
        ];
    }
}