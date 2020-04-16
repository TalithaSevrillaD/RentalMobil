<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataModel extends Model
{
    protected $table="data_mobil";
    protected $primaryKey="id";
    public $timestamps = false;
    protected $fillable = [
        'id_jenis', 'nama_mobil', 'plat', 'merk', 'keterangan'
    ];
}
