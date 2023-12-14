<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwoFactorSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('two_factor_settings', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id');
			$table->integer('security_question_id')->nullable();
			$table->string('answer')->nullable();
			$table->string('hints')->nullable();
			$table->string('security_pin')->nullable();
			$table->string('enable_for')->nullable();
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
        Schema::dropIfExists('two_factor_settings');
    }
}
