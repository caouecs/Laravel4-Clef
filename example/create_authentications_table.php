<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthenticationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authentications', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('email')->nullable();
            $table->string('provider');
            $table->string('provider_uid');
            $table->text('infos')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('authentications');
    }

}
