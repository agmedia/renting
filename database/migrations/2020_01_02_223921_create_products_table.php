<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('author_id')->unsigned()->default(0);
            $table->bigInteger('publisher_id')->unsigned()->default(0);
            $table->bigInteger('action_id')->unsigned()->default(0);
            $table->string('name')->index();
            $table->string('sku', 14)->default(0)->index();
            $table->string('ean', 14)->default(0);
            $table->text('description')->nullable();
            $table->string('slug');
            $table->string('image')->nullable();
            $table->decimal('price', 15, 4)->default(0);
            $table->integer('quantity')->unsigned()->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('related_products')->nullable();
            $table->integer('tax')->unsigned()->default(25);
            $table->string('pages')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('origin')->nullable();
            $table->string('letter')->nullable();
            $table->string('condition')->nullable();
            $table->string('binding')->nullable();
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned()->index();
            $table->string('image');
            $table->string('alt')->nullable();
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
        });

        Schema::create('product_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('price', 15, 4)->nullable();
            $table->integer('discount')->unsigned()->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->string('link')->nullable();
            $table->integer('link_id')->nullable();
            $table->string('badge')->nullable();
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('clicked')->unsigned()->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('product_category', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->index();
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_actions');
        Schema::dropIfExists('product_category');
    }
}



