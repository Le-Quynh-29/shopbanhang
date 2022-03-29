<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('code', 50);
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('number_phone', 20);
            $table->string('address');
            $table->integer('price');
            $table->tinyInteger('status')->default(1);
            $table->dateTime('order_date');
            $table->dateTime('received_date')->nullable();
            $table->dateTime('cancellation_date')->nullable();
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
