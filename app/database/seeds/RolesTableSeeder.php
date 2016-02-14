<?php

class RolesTableSeeder extends Seeder {

	public function run()
	{
		//

		Role::create(array(
			'id'			=> 1
			,'code' 		=> 'A'
			,'name' 		=> 'Admin'
			,'description'	=> 'Administrator account.'
		));

		Role::create(array(
			'id'			=> 2
			,'code' 		=> 'M'
			,'name' 		=> 'Moderator'
			,'description'	=> 'Moderator account.'
		));

		Role::create(array(
			'id'			=> 3
			,'code' 		=> 'J'
			,'name' 		=> 'Judge'
			,'description'	=> 'Judge account.'
		));

		Role::create(array(
			'id'			=> 4
			,'code' 		=> 'SB'
			,'name' 		=> 'Score Board'
			,'description'	=> 'Score board account.'
		));
	}

}
