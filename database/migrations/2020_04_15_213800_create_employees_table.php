<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('employees', function (Blueprint $table) {
      $table->id('id');
      $table->string('nama');
      $table->string('foto')->nullable();
      $table->string('no_telp');
      $table->string('email');
      $table->string('address'); // gk penting
      $table->string('sallery'); // gk penting
      $table->string('nid')->nullable(); // gk penting
      $table->string('joining_date');
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
    Schema::dropIfExists('employees');
  }
}