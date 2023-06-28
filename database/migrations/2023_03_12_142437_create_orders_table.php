<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('order_status')->default(0);
            $table->unsignedInteger('user_id');
            $table->string('user_name');
            $table->string('email');
            $table->string('tel');
            $table->string('address');
            $table->unsignedInteger('product_id');
            $table->integer('quantity');
            $table->unsignedInteger('money');
            $table->text('send_memo');
            $table->unsignedInteger('shipping_fee');
            $table->unsignedInteger('discount_price');
            $table->timestamp('verified_at');
            $table->timestamps();
            $table->softDeletes();
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
};
