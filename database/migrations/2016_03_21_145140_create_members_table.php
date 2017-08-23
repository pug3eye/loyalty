<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('shop_id')->unsigned();
			$table->integer('point')->unsigned();
			$table->boolean('is_member');
			$table->timestamps();

			$table->foreign('customer_id')
						->references('id')
						->on('customers')
						->onDelete('cascade');

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
		Schema::drop('members');
	}

}
