<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beritas extends Model
{
    use HasFactory;

    protected $table = "tb_beritas";

    protected $fillable = [
        'id_berita',
        'judul',
        'keterangan',
    ];

   protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s', // Change your format
        'updated_at' => 'datetime:Y-m-d H:i:s', // Change your format
    ];
}
