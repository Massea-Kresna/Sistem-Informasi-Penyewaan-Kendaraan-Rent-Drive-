<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model {
    protected $table = 'mobil';
    protected $primaryKey = 'id_mobil';
    protected $guarded = [];
    public $timestamps = false;
}