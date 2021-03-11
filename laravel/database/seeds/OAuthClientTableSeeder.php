<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create website client secret
		
		\App\OAuthClient::create([
			'id' => 'g3b259fde3ed9ff3843839b',
			'secret' => '3d7f5f8f793d59c25502c0ae8c4a95b',
			'name' => 'Android'
		]);
		
		\App\OAuthClient::create([
			'id' => 'g3b259fde3ed5ff3843839b',
			'secret' => '3d7f5f8f793d29c25502c0ae8c4a95b',
			'name' => 'Website' 
		]);
    }
}
