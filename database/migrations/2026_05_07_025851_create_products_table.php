<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments ('id');;
            $table->string('name', 200)->unique();
            $table->float('price', 20, 3);
            $table->float('sale_price', 20, 3);
            $table->string('image');
            $table->unsignedInteger('category_id');
            $table->tinyInteger('status');
            $table->text('description'); 
            $table->foreign('category_id')->references('id')->on('categories');     
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
        Schema::table('products',function (Blueprint $table){
            $table->dropForeign('products_category_id_foreign');
        });
        Schema::dropIfExists('products');
    }
}
