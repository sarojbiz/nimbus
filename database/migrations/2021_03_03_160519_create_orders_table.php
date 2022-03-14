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
            $table->bigIncrements('id');
            $table->string('order_no')->nullable();
            $table->string('b_first_name');
            $table->string('b_last_name')->nullable();
            $table->string('b_email')->nullable();
            $table->string('b_street_address')->nullable();
            $table->string('b_city')->nullable();
            $table->string('b_postcode')->nullable();
            $table->string('b_state')->nullable();
            $table->string('b_phone')->nullable();
            $table->string('b_country')->nullable();
            $table->string('s_first_name')->nullable();
            $table->string('s_last_name')->nullable();
            $table->string('s_email')->nullable();
            $table->string('s_street_address')->nullable();
            $table->string('s_city')->nullable();
            $table->string('s_postcode')->nullable();
            $table->string('s_state')->nullable();
            $table->string('s_phone')->nullable();
            $table->string('s_country')->nullable();
            $table->decimal('total', 10, 2);
            $table->integer('order_status_id')->default('1');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->string('identifier')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
