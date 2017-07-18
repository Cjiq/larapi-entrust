<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
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
      Schema::create('password_resets', function (Blueprint $table) {
        $table->string('email')->index();
        $table->string('token')->index();
        $table->timestamp('created_at');
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
      Schema::drop('password_resets');
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
    DB::commit();
  }
}
