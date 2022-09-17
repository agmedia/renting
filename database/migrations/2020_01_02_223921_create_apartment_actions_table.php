<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('apartment_actions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('discount', 15, 4)->nullable();
            $table->decimal('extra', 15, 4)->nullable();
            $table->string('group');
            $table->text('links')->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('logged')->default(0);
            $table->integer('uses_customer')->unsigned()->default(1);
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('clicked')->unsigned()->default(0);
            $table->boolean('repeat')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('apartment_actions_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_action_id')->index();
            $table->string('lang', 2)->default(config('app.locale'));
            $table->string('title');
            $table->timestamps();

            $table->foreign('apartment_action_id')
                  ->references('id')->on('apartment_actions')
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
        Schema::dropIfExists('apartment_actions');
        Schema::dropIfExists('apartment_actions_translations');
    }
}



