<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pelanggan extends Model
{
    protected $table = 'Pelanggan';
    protected $primaryKey = 'id_Pelanggan';
    protected $guarded = [];
    public $timestamps = false;
}
