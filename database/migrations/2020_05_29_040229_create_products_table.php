<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('pdt_id');
            $table->string('mcode', 50)->nullable();
			$table->string('pdt_code', 50)->nullable();
			$table->decimal('inventory_sku', 10, 5)->default(0);
            $table->string('pdt_name', 255)->nullable();
            $table->string('slug', 50)->nullable();
            $table->longText('pdt_short_description')->nullable();
            $table->longText('pdt_long_description')->nullable();
            $table->integer('category_code')->default(0);
            $table->string('pdt_brand', 50)->nullable();
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sales_price', 10, 2)->nullable();
            $table->string('measurement_unit', 50)->nullable();            
            $table->boolean('has_size_color')->default(0);
            $table->boolean('is_feature_product')->default(0);
            $table->boolean('is_sale_product')->default(0);
            $table->enum('stock_status', ['instock', 'outstock'])->default('instock');            
            $table->string('feature_image', 255)->nullable();
            $table->json('gallery_images', 255)->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->tinyInteger('product_status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
