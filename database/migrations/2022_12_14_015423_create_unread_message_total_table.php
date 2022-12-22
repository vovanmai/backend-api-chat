<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnreadMessageTotalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unread_message_total', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_channel_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('number_of_unread')->default(0);
            $table->timestamps();

            $table->foreign('chat_channel_id')
                ->references('id')
                ->on('chat_channels')
                ->restrictOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unread_message_total');
    }
}
