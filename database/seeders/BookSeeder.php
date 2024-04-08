<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('books')->truncate();
        
        $this->command->warn(PHP_EOL . 'Creatung books...');
        
        $count = 1000;
        
        $this->command->getOutput()->progressStart($count);
        
        for( $i = 0; $i < $count; $i++ ) {
            Book::factory(1)->create();
            $this->command->getOutput()->progressAdvance();
        }
        
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Books created');
        
        //$fact = new BookFactory();
        //$fact->count(1000)->create();
    }
}
