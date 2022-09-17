<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id')->default(0);
            $table->string('sku')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('state')->nullable();
            $table->integer('type')->unsigned()->default(0); // tip: apartman, soba, kuća...
            $table->integer('target')->unsigned()->default(0); // (namjena), najam, prodaja
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price_regular', 15, 4)->default(0);
            $table->decimal('price_weekends', 15, 4)->default(0);
            $table->integer('price_per')->unsigned()->default(0);
            $table->integer('tax_id')->unsigned()->default(0);
            $table->decimal('special', 15, 4)->nullable();
            $table->timestamp('special_from')->nullable();
            $table->timestamp('special_to')->nullable();
            $table->integer('m2')->unsigned()->default(0);
            $table->integer('beds')->unsigned()->default(0);
            $table->integer('rooms')->unsigned()->default(0);
            $table->integer('baths')->unsigned()->default(0);
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();

            /*$table->foreign('action_id')
                  ->references('id')->on('apartment_actions');*/
        });


        Schema::create('apartment_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id')->index();
            $table->string('lang', 2)->default(config('app.locale'));
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('slug');
            $table->string('url', 255);
            $table->string('tags')->nullable();
            $table->timestamps();

            $table->foreign('apartment_id')
                  ->references('id')->on('apartments')
                  ->onDelete('cascade');
        });


        Schema::create('apartment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id')->index();
            $table->string('value');
            $table->string('group')->nullable();
            $table->string('icon')->nullable();
            $table->integer('gallery_id')->nullable()->unsigned();
            $table->boolean('amenity')->default(false);
            $table->boolean('favorite')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('apartment_id')
                  ->references('id')->on('apartments')
                  ->onDelete('cascade');
        });


        Schema::create('apartment_details_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_detail_id')->index();
            $table->string('lang', 2)->default(config('app.locale'));
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('group_title')->nullable();
            $table->timestamps();

            $table->foreign('apartment_detail_id')
                  ->references('id')->on('apartment_details')
                  ->onDelete('cascade');
        });


        Schema::create('apartment_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id')->index();
            $table->string('image');
            $table->boolean('default')->default(false);
            $table->boolean('published')->default(false);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();

            $table->foreign('apartment_id')
                  ->references('id')->on('apartments')
                  ->onDelete('cascade');
        });


        Schema::create('apartment_images_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_image_id')->index();
            $table->string('lang', 2)->default(config('app.locale'));
            $table->string('title')->nullable();
            $table->string('alt')->nullable();
            $table->timestamps();

            $table->foreign('apartment_image_id')
                  ->references('id')->on('apartment_images')
                  ->onDelete('cascade');
        });


        Schema::create('apartment_to_category', function (Blueprint $table) {
            $table->unsignedBigInteger('apartment_id')->index();
            $table->unsignedBigInteger('category_id')->index();

            $table->foreign('apartment_id')
                  ->references('id')->on('apartments');

            $table->foreign('category_id')
                  ->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
        Schema::dropIfExists('apartment_translations');
        Schema::dropIfExists('apartment_details');
        Schema::dropIfExists('apartment_details_translations');
        Schema::dropIfExists('apartment_images');
        Schema::dropIfExists('apartment_images_translations');
        Schema::dropIfExists('apartment_to_category');
    }
}



