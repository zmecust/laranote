<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->comment('名称');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('notes_count')->default(0);
            $table->timestamps();
        });

        Schema::create('note_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('note_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();
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
        Schema::dropIfExists('tags');
        Schema::dropIfExists('note_tag');
    }
}
