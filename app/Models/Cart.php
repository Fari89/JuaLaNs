<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'nama_pembeli',
        'harga', // Pastikan ini ada dan namanya 'harga'
        'alamat',
        'no_hp',
        'jumlah', // Pastikan ini ada
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
