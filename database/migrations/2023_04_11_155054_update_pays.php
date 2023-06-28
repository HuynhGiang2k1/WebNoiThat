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
        Schema::table('pays', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('user_name');
            $table->dropColumn('email');
            $table->dropColumn('tel');
            $table->dropColumn('product_id');
            $table->dropColumn('send_memo');
            $table->string('vnp_bank_code')->after('vnpay_code');
            $table->string('vnp_TransactionNo')->after('vnp_bank_code');
            $table->string('vnp_TmnCode')->after('vnp_TransactionNo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pays', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after('order_id');
            $table->string('user_name')->after('user_id');
            $table->string('email')->after('user_name');
            $table->string('tel')->after('email');
            $table->unsignedInteger('product_id')->after('tel');
            $table->text('send_memo')->after('product_id');
            $table->dropColumn('vnp_bank_code');
            $table->dropColumn('vnp_TransactionNo');
            $table->dropColumn('vnp_TmnCode');
        });
    }
};
