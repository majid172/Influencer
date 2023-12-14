<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
			$table->string('title')->nullable();
			$table->string('tag')->nullable();
			$table->longText('plan')->nullable();
			$table->longText('description')->nullable();
			$table->longText('extra_services')->nullable();
			$table->string('image')->nullable();
			$table->string('optional_image')->nullable();
			$table->string('faqs')->nullable();
			$table->string('requirement_ques')->nullable();
			$table->string('video')->nullable();
			$table->string('document')->nullable();
			$table->tinyInteger('status')->default(1)->comment('Approved => 1, Canceled => 2, Pending => 0');
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
        Schema::dropIfExists('listings');
    }
}
