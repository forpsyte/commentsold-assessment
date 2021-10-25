<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'id',
        'product_id',
        'inventory_id',
        'street_address',
        'apartment',
        'city',
        'state',
        'country_code',
        'zip',
        'phone_number',
        'email',
        'name',
        'order_status',
        'payment_ref',
        'transaction_id',
        'payment_amount_cents',
        'ship_charged_cents',
        'ship_cost_cents',
        'subtotal_cents',
        'total_cents',
        'shipper_name',
        'payment_date',
        'shipped_date',
        'tracking_number',
        'tax_total_cents',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the associated product with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the associated user/admin with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Product::class);
    }

    /**
     * Filter the collection by sku or product.
     *
     * @param Builder $query
     * @param array $filters
     * @return void
     */
    public function scopeFilter(Builder $query, $filters)
    {
        $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            $query
                ->leftJoin('products as p', 'orders.product_id', '=', 'p.id')
                ->leftJoin('inventories as i', 'orders.inventory_id', '=', 'i.id')
                ->where(function (Builder $query) use ($search) {
                $query->where('p.product_name', 'like', '%'.$search.'%')
                    ->orWhere('i.sku', 'like', '%'.$search.'%');

            });
        })->when($filters['status'] ?? null, function (Builder $query, $status){
            $query->where('order_status', $status);
        });
    }

    /**
     * @param Builder $query
     * @param array $column
     */
    public function scopeSort(Builder $query, $column)
    {
        $sort = !empty($column['sortBy']) && !empty($column['direction']) ?
            [
                'sortBy' => $column['sortBy'],
                'direction' => $column['direction']
            ] : null;
        $query->when($sort ?? null, function (Builder $query, $sort) {
            $query->orderBy($sort['sortBy'], $sort['direction']);
        })->when(true, function (Builder $query){
            $query->orderBy('id', 'desc');
        });
    }
}
