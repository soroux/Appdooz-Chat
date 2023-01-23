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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('message')->nullable();
            $table->longText('attachment_file')->nullable();
            $table->foreignId('reply_id')->nullable();
            $table->foreignId('service_id');
            $table->foreignId('type_id');
            $table->foreignId('channel_type_id');
            $table->foreignId('sender_id');
            $table->foreignId('receiver_id')->nullable();
            $table->foreignId('group_id')->nullable();
            $table->boolean('delivered')->default(false);
            $table->boolean('seen')->default(false);
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
};
