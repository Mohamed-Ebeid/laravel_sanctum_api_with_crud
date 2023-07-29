<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInter('user_id');
      $table->string('name');
      $table->string('description');
      $table->string('priority')->default('mediun');
      $table->foregin('user_id')
          ->reference('id')
          ->on('users')
          ->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tasks');
  }
};
