<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->insert([
            'id_user' => 87,
            'location' => 'Boveda',
            'type' => 'documento',
            'folio' => 12345678,
            'expedition' => Carbon::now()->format('Y-m-d H:i:s'),
            'expiration' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        DB::table('documents')->insert([
            'id_user' => 87,
            'location' => 'Boveda',
            'type' => 'IFE',
            'folio' => 123456,
            'expedition' => Carbon::now()->format('Y-m-d H:i:s'),
            'expiration' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        
        DB::table('documents')->insert([
            'id_user' => 87,
            'location' => 'Boveda',
            'type' => 'Pasaporte',
            'folio' => 123456789,
            'expedition' => Carbon::now()->format('Y-m-d H:i:s'),
            'expiration' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        DB::table('documents_movements')->insert([
            'document_id' => 1,
            'new_location' => 'Cliente',
            'date' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        DB::table('documents_movements')->insert([
            'document_id' => 1,
            'new_location' => 'Boveda',
            'date' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        
        DB::table('documents_movements')->insert([
            'document_id' => 2,
            'new_location' => 'Cliente',
            'date' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        DB::table('documents_movements')->insert([
            'document_id' => 3,
            'new_location' => 'Cliente',
            'date' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        
        DB::table('documents_movements')->insert([
            'document_id' => 3,
            'new_location' => 'Boveda',
            'date' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
    }
}
