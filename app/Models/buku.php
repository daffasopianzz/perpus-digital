<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    protected $table = 'buku';

    public function kategorii()
    {
        return $this->belongsTo(kategori::class, 'kategori', 'id');
    }


}