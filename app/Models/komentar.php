<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komentar extends Model
{
    protected $table = 'komentar';

    public function id_user_a()
    {
        return $this->belongsTo(user::class, 'id_user', 'id');
    }


}