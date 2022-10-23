<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('books')->insert([
            'title' => 'A song about ice and fire',
            'description' => 'A Song of Ice and Fire takes place on the fictional continents Westeros and Essos. The point of view of each chapter in the story is a limited perspective of a range of characters growing from nine in the first novel, to 31 characters by the fifth novel. Three main stories interweave: a dynastic war among several families for control of Westeros, the rising threat of the supernatural Others in northernmost Westeros, and the ambition of the deposed king\'s exiled daughter to assume the Iron Throne.',
            'author' => 'George R. R. Martin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('books')->insert([
            'title' => 'Kingdom',
            'description' => 'The story of Kingdom is a fictional adaptation of the Chinese history period known as the Warring States period, which ended in 221 BC when Ying Zheng, king of Qin, succeeded in conquering the other states and unifying China. Several of the characters are based on historical figures. Many characters will take the names of people in history, and other times they will have completely different names; oftentimes, this is the result of Japanese kanji borrowing from Chinese characters, and some Chinese names have no equivalent characters in kanji.',
            'author' => 'Yasuhisa Hara',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
