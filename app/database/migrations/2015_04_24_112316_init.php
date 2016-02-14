<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// initial shema

		Schema::create('municipalities', function($table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->smallInteger('zip_code');
		});

		Schema::create('people', function($table)
		{
			$table->increments('id');

			$table->integer('municipality_id')->unsigned()->nullable();
			$table->foreign('municipality_id')
				->references('id')
				->on('municipalities')
				->oUpdate('cascade')
				->onDelete('cascade');

			$table->string('first_name', 50)->nullable();
			$table->string('middle_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();

			$table->date('birth_date')->nullable()->default(null);
			$table->string('gender', 6)->nullable();

			$table->timestamps();
		});

		Schema::create('roles', function($table)
		{
			$table->increments('id');
			$table->string('code', 8);
			$table->string('name', 32);
			$table->text('description');
		});

		Schema::create('users', function($table)
		{
			$table->increments('id');

			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')
				->references('id')
				->on('roles')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->integer('person_id')->unsigned()->nullable();
			$table->foreign('person_id')
				->references('id')
				->on('people')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->string('username', 16)->unique();
			$table->string('password', 60);

			$table->boolean('verified')->default(false);
			$table->string('remember_token', 100);
			$table->timestamps();
		});

		Schema::create('events', function($table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->text('description')->nullable();
			$table->date('date')->nullable()->default(null);
			$table->timestamps();
		});

		Schema::create('portions', function($table)
		{
			$table->increments('id');
			$table->integer('event_id')->unsigned();
			$table->foreign('event_id')
				->references('id')
				->on('events')
				->onUpdate('cascade')
				->onDelete('cascade');
			
			$table->string('name');
			$table->decimal('points', 4, 1);
			$table->text('description')->nullable();

			$table->timestamps();
		});

		Schema::create('criteria', function($table)
		{
			$table->increments('id');
			$table->integer('portion_id')->unsigned();
			$table->foreign('portion_id')
				->references('id')
				->on('portions')
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->string('name', 100);
			$table->decimal('points', 4, 1);
			$table->text('description');
		});

		Schema::create('contestants', function($table)
		{
			$table->increments('id');

			$table->integer('person_id')->unsigned();
			$table->foreign('person_id')
				->references('id')
				->on('people')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->integer('event_id')->unsigned();
			$table->foreign('event_id')
				->references('id')
				->on('events')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->integer('municipality_id')->unsigned();
			$table->foreign('municipality_id')
				->references('id')
				->on('municipalities')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('judges', function($table)
		{
			$table->increments('id');

			$table->integer('event_id')->unsigned();
			$table->foreign('event_id')
				->references('id')
				->on('events')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('states', function($table)
		{
			$table->increments('id');

			// current event
			$table->integer('event_id')->unsigned();
			$table->foreign('event_id')
				->references('id')
				->on('events')
				->onUpdate('cascade')
				->onDelete('cascade');

			// current portion
			$table->integer('current_portion_id')->unsigned()->nullable()->default(null);
			$table->foreign('current_portion_id')
				->references('id')
				->on('portions')
				->onUpdate('cascade')
				->onDelete('cascade');

			// current contestant
			$table->integer('current_contestant_id')->unsigned()->nullable()->default(null);
			$table->foreign('current_contestant_id')
				->references('id')
				->on('contestants')
				->onUpdate('cascade')
				->onDelete('cascade');
			
			$table->string('event_status', 16)->default('UNSTARTED');	// values: UNSTARTED/STARTED/PASUED/ENDED
			$table->boolean('allow_scoring')->default(false);
			$table->boolean('show_scoreboard')->default(true);
		});

		Schema::create('ratings', function($table)
		{
			$table->increments('id');

			// current event
			$table->integer('event_id')->unsigned();
			$table->foreign('event_id')
				->references('id')
				->on('events')
				->onUpdate('cascade')
				->onDelete('cascade');

			// current portion
			$table->integer('portion_id')->unsigned();
			$table->foreign('portion_id')
				->references('id')
				->on('portions')
				->onUpdate('cascade')
				->onDelete('cascade');

			// current criterion
			$table->integer('criterion_id')->unsigned();
			$table->foreign('criterion_id')
				->references('id')
				->on('criteria')
				->onUpdate('cascade')
				->onDelete('cascade');

			// current contestant
			$table->integer('contestant_id')->unsigned();
			$table->foreign('contestant_id')
				->references('id')
				->on('contestants')
				->onUpdate('cascade')
				->onDelete('cascade');

			// current contestant
			$table->integer('judge_id')->unsigned();
			$table->foreign('judge_id')
				->references('id')
				->on('judges')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->decimal('points', 4, 1)->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
