<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rewards', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shop_id')->unsigned();
			$table->string('barcode', 50);
			$table->string('name', 200);
			$table->integer('point_use');
			$table->string('detail', 200);
			$table->string('image', 200)->nullable();
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
		Schema::drop('rewards');
	}

}
