<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shop_id')->unsigned();
			$table->string('barcode', 50);
			$table->string('name', 200);
			$table->decimal('price', 10, 2);
			$table->integer('point');
			$table->boolean('has_promotion');
			$table->decimal('promotion_price', 10, 2)->nullable();
			$table->integer('promotion_point')->nullable();
			$table->string('detail', 200)->nullable();
			$table->string('image', 200)->nullable();
			$table->date('promotion_start')->nullable();
			$table->date('promotion_end')->nullable();
			$table->timestamps();

			$table->foreign('shop_id')
						->references('id')
						->on('shops')
						->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
