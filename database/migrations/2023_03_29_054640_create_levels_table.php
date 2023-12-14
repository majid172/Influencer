<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
			$table->integer('minimum_complete_orders')->default(0)->comment('all time');
			$table->decimal('minimum_earn_amount', 11,8)->default(0);
			$table->integer('add_extra_services')->default(0)->comment('per service');
			$table->integer('withdraw_earnings')->default(0)->comment('after 7* days');
			$table->string('image')->nullable();
			$table->string('driver')->nullable();
			$table->tinyInteger('status')->default(1)->comment('Enable => 1, Disable => 0');
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
        Schema::dropIfExists('levels');
    }
}
