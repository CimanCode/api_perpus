<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $guarded = 'id';
    protected $fillable = [
        'judul',
        'penulis',
        'deskripsi',
        'gambar'
    ];
}
