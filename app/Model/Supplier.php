<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
  protected $fillable = [
    'nama', 'email', 'no_telp', 'alamat', 'nama_toko', 'foto'
  ];
}