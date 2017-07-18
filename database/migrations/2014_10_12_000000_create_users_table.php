<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    DB::beginTransaction();
    try {
      Schema::create('user', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
      });

    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
    DB::commit();

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    DB::beginTransaction();
    try {
      Schema::drop('user');
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
    DB::commit();

  }
}
