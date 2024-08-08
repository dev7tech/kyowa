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
            $table->string('order_number');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');
            $table->float('freight')->default(0);
            $table->float('point')->default(0);
            $table->unsignedBigInteger('payment_id');
            $table->integer('status');
            $table->string('order_from');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('address_id')
                ->references('id')
                ->on('address')
                ->onDelete('cascade');
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->onDelete('cascade');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_payment_id_foreign');
            $table->dropForeign('orders_address_id_foreign');
            $table->dropForeign('orders_user_id_foreign');
        });
        Schema::dropIfExists('orders');
    }
}
