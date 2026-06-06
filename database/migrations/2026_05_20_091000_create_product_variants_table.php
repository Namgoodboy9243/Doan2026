<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('sku', 100)->nullable();
            $table->string('cpu', 100)->nullable();
            $table->string('ram', 50)->nullable();
            $table->string('storage', 100)->nullable();
            $table->string('color', 50)->nullable();
            $table->float('price', 20, 3);
            $table->integer('stock')->default(0);
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
                  
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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropForeign('product_variants_product_id_foreign');
        });
        Schema::dropIfExists('product_variants');
    }
}
