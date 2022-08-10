<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
        });


        Schema::create('gallery_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id')->index();
            $table->string('lang', 2)->default('hr');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('gallery_id')
                  ->references('id')->on('galleries')
                  ->onDelete('cascade');
        });


        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id')->index();
            $table->string('image');
            $table->string('alt')->nullable();
            $table->boolean('published')->default(false);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();

            $table->foreign('gallery_id')
                  ->references('id')->on('galleries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('gallery_translations');
        Schema::dropIfExists('gallery_images');
    }
}



