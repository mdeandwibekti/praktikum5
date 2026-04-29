<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'image',
        'title',
        'description',
        'stock',
        'user_id',
    ];

    /**
     * attributes
     *
     * @var array
     */
    protected $attributes = [
        'description' => '',
        'image' => null,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
