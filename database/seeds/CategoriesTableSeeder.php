<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
  public function run()
  {
       DB::table('pages')->insert([
           [
           'title' => 'IT',
           'uri' 	=> 'it',
           'content'=> 'This is the sport category.',
           'type' => 'category',
           'language' => Lang::getLocale(),
           'parent_id' => null,
           'lft' => 3,
           'rgt' => 6,
           'depth' => 0
           ],
           [
           'title' => 'Headlines',
           'uri' 	=> 'headlines',
           'content'=> 'This is the headlines category.',
           'type' => 'category',
           'language' => Lang::getLocale(),
           'parent_id' => 7,
           'lft' => 4,
           'rgt' => 5,
           'depth' => 1
           ],
           [
           'title' => 'Opinion',
           'uri' 	=> 'opinion',
           'content'=> 'This is the opinion category.',
           'type' => 'category',
           'language' => Lang::getLocale(),
           'parent_id' => null,
           'lft' => 1,
           'rgt' => 2,
           'depth' => 0
           ],
           [
           'title' => 'World',
           'uri'   => 'world',
           'content'=> 'This is the world category.',
           'type' => 'category',
           'language' => Lang::getLocale(),
           'parent_id' => null,
           'lft' => 7,
           'rgt' => 8,
           'depth' => 0
           ]
           ]);

       

  }
}
