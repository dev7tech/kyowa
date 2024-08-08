<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('conversation_unique');
            $table->integer('type');//chat type = 1: text, 2 image, 3 audio, 4 video;
            $table->text('content_text')->nullable();
            $table->text('content_image')->nullable();
            $table->integer('sender_id');
            $table->boolean('is_show')->default(false);
            $table->binary('delete_users')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
