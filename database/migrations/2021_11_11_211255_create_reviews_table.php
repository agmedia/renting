<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id')->default(0)->index();
            $table->unsignedBigInteger('order_id')->default(0);
            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('lang', 2)->default('hr');
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->default('media/avatar.jpg');
            $table->string('message');
            $table->decimal('stars', 4)->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();

            /*$table->foreign('apartment_id')
                  ->references('id')->on('apartments');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}



