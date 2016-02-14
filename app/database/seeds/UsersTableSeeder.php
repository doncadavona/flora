<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		//

		User::create(array(
			'username' 		=> 'admin'
			,'password'		=> Hash::make('123456')
			,'role_id'		=> 1
			,'verified'		=> true
		));

		User::create(array(
			'username' => 'moderator'
			,'password'	=> Hash::make('123456')
			,'role_id'	=> 2
			,'verified'	=> true
		));

		User::create(array(
			'username' => 'score_board'
			,'password'	=> Hash::make('123456')
			,'role_id'	=> 4
			,'verified'	=> true
		));
	}

}
