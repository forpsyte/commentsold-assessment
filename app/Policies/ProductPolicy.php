<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function save(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function delete(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }
}
