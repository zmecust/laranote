<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('notes_count')->default(0)->comment('笔记数');
            $table->enum('is_banned', ['T', 'F'])->default('F')->index();
            $table->enum('email_notify_enabled', ['T', 'F'])->default('F')->index();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
