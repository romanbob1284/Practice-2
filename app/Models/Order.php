<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'status',
        'payment_method',
        'password',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class, 'user_id', 'id'); }

    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class, 'dish_order', 'order_id', 'dish_id', 'id', 'id');
    }
}
