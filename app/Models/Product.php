<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_name',
        'description',
        'style',
        'brand',
        'created_at',
        'updated_at',
        'url',
        'product_type',
        'shipping_prince',
        'note',
    ];

    /**
     * Get the associated user with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the associated orders with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the associated inventory items with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * @return array
     */
    public function getSkusAttribute()
    {
        $skus = [];
        $inventories = $this->inventories;

        foreach ($inventories as $inventory) {
            $skus[] = $inventory->sku;
        }
        return $skus;
    }
}
