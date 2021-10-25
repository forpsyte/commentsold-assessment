<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Inventory extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'id',
        'product_id',
        'quantity',
        'color',
        'size',
        'weight',
        'price_cents',
        'sales_price_cents',
        'cost_cents',
        'sku',
        'length',
        'width',
        'height',
        'note',
    ];

    /**
     * Get the associated product with the inventory.
     *
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the associated orders with the product.
     *
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the associated user with the inventory.
     *
     * @return HasOneThrough
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Product::class);
    }

    /**
     * Filters the collection by the quantity.
     *
     * @param Builder $query
     * @param $threshold
     * @param $quantity
     * @return Builder|null
     */
    public function scopeWhereQuantity(Builder $query, $threshold, $quantity)
    {
        switch ($threshold) {
            case 'upper': return $query->where('quantity', '>=', intval($quantity));
            case 'lower': return $query->where('quantity', '<=', intval($quantity));
            default: return null;
        }
    }

    /**
     * Filter the collection by sku or product ID.
     *
     * @param Builder $query
     * @param array $filters
     * @return void
     */
    public function scopeFilter(Builder $query, $filters)
    {
        $filterQuantity = !empty($filters['threshold']) && !empty($filters['quantity']) ?
            [
                'threshold' => $filters['threshold'],
                'quantity' => $filters['quantity']
            ] : null;
        $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('sku', 'like', '%'.$search.'%')
                    ->orWhere('product_id', '=', $search);
            });
        })->when($filterQuantity, function (Builder $query, $filter){
            $query->whereQuantity($filter['threshold'], $filter['quantity']);
        });
    }
}
