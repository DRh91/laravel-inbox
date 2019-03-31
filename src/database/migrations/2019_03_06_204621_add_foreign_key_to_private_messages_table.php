<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToPrivateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('private_messages', function (Blueprint $table)
        {
            // create column
            $table->unsignedInteger('fk_id_user_sender')->after('id');
            $table->unsignedInteger('fk_id_conversation')->nullable(true);

            // add foreign key
            $table->foreign('fk_id_user_sender')->references('id')->on('users')->onDelete('CASCADE');

            $table->foreign('fk_id_conversation')
                  ->references('id')
                  ->on('conversations')
                  ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('private_messages', function (Blueprint $table)
        {
            $table->dropForeign('private_messages_fk_id_user_sender_foreign');
            $table->dropColumn('fk_id_user_sender');

            $table->dropForeign('private_messages_fk_id_conversation_foreign');
            $table->dropColumn('fk_id_conversation');
        });
    }
}
