<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenyewaModel extends Model
{
    protected $table="penyewa";
    protected $primaryKey="id";
    public $timestamps=false;
    protected $fillable = [
        'nama', 'alamat', 'nohp','no_ktp', 'foto'
    ];
}
