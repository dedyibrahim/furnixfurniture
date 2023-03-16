<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarProduks extends Model
{
    use HasFactory;

    protected $table = "tb_gambarproduks";
    protected $fillable = [
        'id_gambar',
        'id_kategori',
        'name',
    ];
}
