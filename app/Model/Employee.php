<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  protected $fillable = [
    'nama', 'foto', 'email', 'no_telp', 'joining_date',
    'address', 'sallery', 'nid',  // gk penting
  ];
}