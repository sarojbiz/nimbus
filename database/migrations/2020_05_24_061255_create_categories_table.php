<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id');
			$table->string('category_name', 50);
			$table->integer('parent_category_id')->default(0);
			$table->string('category_image', 255)->nullable();
            $table->string('category_description', 200)->nullable();
            $table->string('category_slug', 255);
            $table->integer('category_level')->default(0);
			$table->char('category_type')->nullable();
			$table->integer('created_by')->nullable();			
			$table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
