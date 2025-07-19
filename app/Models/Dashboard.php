<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'deskripsi',
        'foto'
    ];
}
