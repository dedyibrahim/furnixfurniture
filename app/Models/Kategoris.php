<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoris extends Model
{   use HasFactory;
    protected $table = "tb_kategoris";
    protected $fillable = [
        'id_kategori',
        'nama_kategori',
    ];
}
