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
        Schema::create('pays', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('user_id');
            $table->string('user_name');
            $table->string('email');
            $table->string('tel');
            $table->unsignedInteger('product_id');
            $table->text('send_memo');
            $table->unsignedInteger('money');
            $table->string('vnpay_code');
            $table->unsignedTinyInteger('status')->default(0);
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
        Schema::dropIfExists('pays');
    }
};
