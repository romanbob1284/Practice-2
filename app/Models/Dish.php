<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dish extends Model
{
    use HasFactory;
    
    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
        ];
    }

    protected $fillable = [
        'title',
        'description',
        'price',
        'ingredients',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'dish_order', 'dish_id', 'order_id', 'id', 'id');
    }
}
