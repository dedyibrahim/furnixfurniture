<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamus extends Model
{
    use HasFactory;
    protected $table = "tb_tamus";
    protected $fillable = [
        'id_tamu',
        'nama',
        'email',
        'tlp',
        'keterangan',
    ];
}
