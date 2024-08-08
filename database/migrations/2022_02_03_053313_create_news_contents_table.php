<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('title_id');
            $table->string('content');
            $table->integer('product_id');
            $table->string('image')->nullable();
            $table->string('media')->nullable();
            $table->foreign('title_id')
                ->references('id')
                ->on('news_titles')
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
        Schema::table('news_contents', function (Blueprint $table) {
            $table->dropForeign('news_contents_title_id_foreign');
        });
        Schema::dropIfExists('news_contents');
    }
}
