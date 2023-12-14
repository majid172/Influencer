<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
			$table->string('name', 100)->nullable();
			$table->string('symbol', 10)->nullable();
			$table->string('code', 100)->nullable();
			$table->string('logo', 100)->nullable();
			$table->decimal('exchange_rate', 18, 8)->default(0);
			$table->tinyInteger('currency_type')->default(0)->comment('0 = crypto, 1 = Fiat');
			$table->tinyInteger('is_active')->default(1)->comment('1 = active, 0 = inactive');
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
        Schema::dropIfExists('currencies');
    }
}
