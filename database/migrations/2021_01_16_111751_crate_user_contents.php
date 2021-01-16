<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateUserContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_contents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subscContentId');
            $table->string('contentName');
            $table->bigInteger('userId');
            $table->string('currentContent');
            $table->string('lastContent');
            $table->boolean('watched');
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
        //
        Schema::dropIfExists('UserContents');
    }
}
