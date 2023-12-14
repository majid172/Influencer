<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_infos', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('personalInfo')->default(0)->comment('0=>Not Submitted, 1=>Submitted');
            $table->tinyInteger('address')->default(0);
            $table->tinyInteger('education')->default(0);
            $table->tinyInteger('certification')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0=Pending, 1=Approved');
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
        Schema::dropIfExists('profile_infos');
    }
}
