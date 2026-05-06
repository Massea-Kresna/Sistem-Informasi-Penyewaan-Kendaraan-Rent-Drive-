<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    protected $table = 'penyewaan';
    protected $primaryKey = 'id_sewa';
    protected $guarded = [];
    public $timestamps = false;
}
