<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->integer('client_id');
			$table->integer('influencer_id');
			$table->integer('listing_id');
			$table->string('order_no',40);
			$table->string('title',255);
			$table->decimal('amount',28,8);
			$table->tinyInteger('payment_type')->comment('1=>gateway,2=>wallet');
			$table->date('delivery_date');
			$table->string('file',255);
			$table->string('driver')->default('local');
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
		Schema::table('orders', function($table) {
			$table->dropColumn('payment_type');
		});
    }
}
