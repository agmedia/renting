<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->unsignedBigInteger('affiliate_id')->default(0);
            $table->integer('order_status_id')->unsigned();
            $table->string('invoice')->nullable();
            $table->decimal('total', 15, 4)->default(0);
            $table->timestamp('date_from');
            $table->timestamp('date_to');
            $table->string('payment_fname');
            $table->string('payment_lname');
            $table->string('payment_address');
            $table->string('payment_zip');
            $table->string('payment_city');
            $table->string('payment_phone')->nullable();
            $table->string('payment_email');
            $table->string('payment_method');
            $table->string('payment_code')->nullable();
            $table->string('payment_card')->nullable();
            $table->integer('payment_installment')->unsigned()->default(0);
            $table->string('hash')->nullable();
            $table->string('company');
            $table->string('oib');
            $table->text('comment')->nullable();
            $table->boolean('approved')->default(false); // Ako admin treba odobriti najam.
            $table->unsignedBigInteger('approved_user_id')->default(0); // ID admina.
            $table->timestamps();

            $table->foreign('apartment_id')
                  ->references('id')->on('apartments');
        });


        Schema::create('order_total', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->string('code')->nullable(); // Can be action, coupon, subtotal, discount, tax, total
            $table->decimal('value', 15, 4)->default(0);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('id')->on('orders');
        });


        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->tinyInteger('success');
            $table->decimal('amount', 10, 2);
            $table->string('signature');
            $table->string('payment_type', 16)->nullable();
            $table->string('payment_plan', 4)->nullable();
            $table->string('payment_partner')->nullable();
            $table->dateTime('datetime');
            $table->string('approval_code')->nullable();
            $table->string('pg_order_id')->nullable();
            $table->string('lang');
            $table->string('stan')->nullable();
            $table->string('error')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('id')->on('orders');
        });


        Schema::create('order_deposit', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->string('signature');
            $table->string('payment_method');
            $table->string('payment_code')->nullable();
            $table->tinyInteger('paid')->default(0);
            $table->dateTime('expire')->nullable();
            $table->integer('status_id')->unsigned();
            $table->string('invoice')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('id')->on('orders');
        });


        Schema::create('order_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('id')->on('orders');

            $table->foreign('user_id')
                  ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_total');
        Schema::dropIfExists('order_transactions');
        Schema::dropIfExists('order_deposit');
        Schema::dropIfExists('order_history');
    }
}
