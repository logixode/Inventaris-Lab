<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  public function dataRelation()
  {
    return $this->belongsTo('App\KategoriInti', 'id_kategori_inti');
  }
  protected $fillable = [
    'nama_kategori', 'id_kategori_inti', 'gambar', 'keterangan'
  ];
}