<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserConversationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_conversation', function (Blueprint $table)
        {
            // create columns
            $table->increments('id');
            $table->unsignedInteger('fk_id_user');
            $table->unsignedInteger('fk_id_conversation');
            $table->timestamp("last_read")->nullable()->default(now());
            $table->timestamps();

            // add foreign keys
            $table->foreign('fk_id_user')->references('id')->on('users')->onDelete('RESTRICT');
            $table->foreign('fk_id_conversation')->references('id')->on('conversations')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_conversation');
    }
}
