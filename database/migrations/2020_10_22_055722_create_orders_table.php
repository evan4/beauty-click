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

            $table->unsignedTinyInteger('status')->defaultValue(0);
            $table->unsignedSmallInteger('total');
            $table->string('address');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->timestamps();


            $table->foreignId('shipping_id')->constrained('shippings')
                ->onDelete('cascade');
            $table->foreignId('payment_id')->constrained('payments')
                ->onDelete('cascade');
                
            $table->foreignId('user_id')->constrained('users')
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
        Schema::dropIfExists('orders');
    }
}
