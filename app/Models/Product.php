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
        'image',
        'title',
        'description',
        'price',
        'stock',
        'user_id', // Tambahkan user_id ke fillable agar bisa diisi saat create
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
