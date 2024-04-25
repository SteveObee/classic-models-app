<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Domains\Baskets\Models\Basket;
use Domains\Baskets\Models\BasketItem;
use Domains\Orders\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'basket_item_count'
    ];

    public function getBasketItemCountAttribute() {
        return $this->basketItems()->count();
    }

    /**
     * Get orders for the user
     *
     */
    public function orders() : HasMany {
        return $this->hasMany(Order::class, 'customerNumber', 'customer_id');
    }

    public function basket() : HasOne {
        return $this->hasOne(Basket::class, 'customer_id', 'customer_id');
    }

    public function basketItems() : HasManyThrough {
        return $this->hasManyThrough(BasketItem::class, Basket::class, 'customer_id', 'basket_id', 'customer_id', 'id');
    }
}
