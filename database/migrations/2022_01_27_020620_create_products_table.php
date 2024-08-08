<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('pcategory_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('codeNo');
            
            $table->string('name');
            $table->float('tax')->nullable();
            $table->string('gauge')->nullable();
            $table->float('qty')->default(0);
            $table->integer('point')->default(0);
            $table->string('mark')->nullable();
            $table->string('description')->nullable();
            $table->integer('order')->default(0);
            $table->integer('related_id')->nullable();
            $table->boolean('is_irregular')->default(false);
            $table->boolean('is_available')->default(true);
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
            $table->foreign('pcategory_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_unit_id_foreign');
            $table->dropForeign('products_pcategory_id_foreign');
            $table->dropForeign('products_category_id_foreign');
        });
        Schema::dropIfExists('products');
    }
}
