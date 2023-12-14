<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escrows', function (Blueprint $table) {
            $table->id();
			$table->integer('client_id');
			$table->integer('freelancer_id');
			$table->integer('hire_id');
			$table->decimal('total_amount');
			$table->decimal('deposit_amount');
			$table->date('payment_date');
			$table->string('project_file');
			$table->string('driver');
			$table->tinyInteger('is_completed');
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
		Schema::table('escrows', function (Blueprint $table) {
			$table->dropColumn('payment_date');
		});
    }
}
