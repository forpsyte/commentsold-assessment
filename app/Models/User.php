<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $casts = [
        'owner' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'owner',
        'shop_name',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
        'shop_domain',
        'is_enabled',
        'billing_plan',
        'trial_starts_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    /**
     * Get the account associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the products associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Product::class);
    }

    /**
     * Get the inventory items associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function inventories()
    {
        return $this->hasManyThrough(Inventory::class, Product::class);
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @param array $filter
     * @return float
     */
    public function getTotalSales($filter)
    {
        return number_format(floatval($this->orders()->filter($filter)->sum('total_cents') / 100), 2);
    }

    /**
     * @param array $filter
     * @return float
     */
    public function getAvgSales($filter)
    {
        return number_format(floatval($this->orders()->filter($filter)->avg('total_cents') / 100), 2);
    }

    /**
     * @param $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    /**
     * @param $query
     */
    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }


    /**
     * @param $query
     * @param $role
     * @return mixed
     */
    public function scopeWhereRole($query, $role)
    {
        switch ($role) {
            case 'user': return $query->where('owner', false);
            case 'owner': return $query->where('owner', true);
            default: return null;
        }
    }

    /**
     * @param $query
     * @param array $filters
     * @return void
     */
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->whereRole($role);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
