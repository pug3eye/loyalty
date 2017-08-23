<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedeemRewardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('redeem_rewards', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('member_id')->unsigned();
			$table->integer('reward_id')->unsigned();
			$table->string('code', 20);
			$table->boolean('used');
			$table->timestamp('created_at');

			$table->foreign('member_id')
						->references('id')
						->on('members')
						->onDelete('cascade');

			$table->foreign('reward_id')
						->references('id')
						->on('rewards')
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
		Schema::drop('redeem_rewards');
	}

}
