<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_deposit', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->string('signature');
            $table->string('payment_method');
            $table->string('payment_code')->nullable();
            $table->tinyInteger('paid')->default(0);
            $table->integer('scope_id')->default(1);
            $table->dateTime('expire')->nullable();
            $table->integer('status_id')->unsigned();
            $table->string('invoice')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('id')->on('orders');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_deposit');
    }
}
