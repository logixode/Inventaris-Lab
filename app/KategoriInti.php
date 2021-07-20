<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriInti extends Model
{
  protected $casts = ['id' => 'string'];
  protected $fillable = [
    'kategori_inti'
  ];
}