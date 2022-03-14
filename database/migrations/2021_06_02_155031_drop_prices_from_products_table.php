<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPricesFromProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('inventory_sku');
            $table->dropColumn('regular_price');
            $table->dropColumn('sales_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
			$table->decimal('inventory_sku', 10, 5)->default(0);
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sales_price', 10, 2)->nullable();            
        });
    }
}
