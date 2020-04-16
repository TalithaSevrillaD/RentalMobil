<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisModel extends Model
{
    protected $table="jenis_mobil";
    protected $primaryKey="id";
    public $timestamps =false;
    protected $fillable = [
        'jenis', 'harga_sewa'
    ];
}
