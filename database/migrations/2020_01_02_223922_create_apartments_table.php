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
            $table->bigIncrements('id');
            $table->bigInteger('action_id')->unsigned()->default(0);
            $table->string('sku', 14)->default(0)->index();
            $table->string('ean', 14)->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('state')->nullable();
            $table->integer('type')->unsigned()->default(0); // tip: apartman, soba, kuća...
            $table->integer('target')->unsigned()->default(0); // (namjena), najam, prodaja
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('slug');
            $table->string('url', 255);
            $table->string('image')->nullable();
            $table->decimal('price', 15, 4)->default(0);
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
        });

        Schema::create('apartment_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('apartment_id')->unsigned()->index();
            $table->string('lang', 2)->default('hr');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('tags');
            $table->timestamps();
        });

        Schema::create('apartment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('apartment_id')->unsigned()->index();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('value');
            $table->string('icon')->nullable();
            $table->string('gallery')->nullable();
            $table->string('favorite')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('apartment_details_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('apartment_detail_id')->unsigned()->index();
            $table->string('lang', 2)->default('hr');
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->timestamps();
        });

        Schema::create('apartment_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('apartment_id')->unsigned()->index();
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('alt')->nullable();
            $table->boolean('published')->default(false);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
        });

        Schema::create('apartment_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('type');
            $table->decimal('discount', 15, 4);
            $table->string('group');
            $table->text('links')->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('logged')->default(0);
            $table->integer('uses_customer')->unsigned()->default(1);
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('clicked')->unsigned()->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('apartment_category', function (Blueprint $table) {
            $table->integer('apartment_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
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
        Schema::dropIfExists('apartment_actions');
        Schema::dropIfExists('apartment_category');
    }
}



