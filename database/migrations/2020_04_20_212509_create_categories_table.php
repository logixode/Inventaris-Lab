<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {
      $table->id('id');
      $table->string('nama_kategori');
      $table->unsignedInteger('id_kategori_inti');
      $table->string('gambar')->nullable();
      $table->string('keterangan');
      $table->foreign('id_kategori_inti')->references('id')->on('kategori_intis');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('categories');
  }
}