<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('group')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('price', 15, 4)->default(0);
            $table->string('price_per')->nullable();
            $table->text('links')->nullable();
            $table->string('badge')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });


        Schema::create('option_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('option_id')->index();
            $table->string('lang', 2)->default(config('app.locale'));
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('option_id')
                  ->references('id')->on('options')
                  ->onDelete('cascade');
        });


        Schema::create('option_to_apartment', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id')->index();
            $table->unsignedBigInteger('apartment_id')->index();

            $table->foreign('option_id')
                  ->references('id')->on('options');

            $table->foreign('apartment_id')
                  ->references('id')->on('apartments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
        Schema::dropIfExists('option_translations');
        Schema::dropIfExists('option_to_apartment');
    }
}



