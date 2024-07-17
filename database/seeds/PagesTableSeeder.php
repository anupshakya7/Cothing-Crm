<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->truncate();

        DB::table('pages')->insert([
            [
            'title' => 'Home',
            'uri'   => '/',
            'name'  => null,
            'content'=> 'This is the media page.',
            'type' => 'page',
            'template' => 'home',
            'hidden' => 0,
            'language' => Lang::getLocale(),
            'parent_id' => null,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0
            ],
            [
            'title' => 'Blog',
            'uri'   => 'blog',
            'name'  => null,
            'content'=> 'This is the blog page.',
            'type' => 'page',
            'template' => 'blog',
            'hidden' => 0,
            'language' => Lang::getLocale(),
            'parent_id' => null,
            'lft' => 3,
            'rgt' => 6,
            'depth' => 0
            ],
            [
            'title' => 'single post',
            'uri'   => 'blog/{id}/{slug}',
            'name'  => 'single-post',
            'content'=> 'This is the single-post page.',
            'type' => 'page',
            'template' => 'singlePost',
            'hidden' => 1,
            'language' => Lang::getLocale(),
            'parent_id' => 2,
            'lft' => 4,
            'rgt' => 5,
            'depth' => 1
            ],
            [
            'title' => 'About',
            'uri' 	=> 'about',
            'name'  => null,
            'content'=> 'This is the about page.',
            'type' => 'page',
            'template' => null,
            'hidden' => 0,
            'language' => Lang::getLocale(),
            'parent_id' => null,
            'lft' => 7,
            'rgt' => 8,
            'depth' => 0
            ],
            [
            'title' => 'Contact',
            'uri' 	=> 'contact',
            'name'  => null,
            'content'=> 'This is the contact page.',
            'type' => 'page',
            'template' => 'contact',
            'hidden' => 0,
            'language' => Lang::getLocale(),
            'parent_id' => null,
            'lft' => 9,
            'rgt' => 10,
            'depth' => 0
            ],
            
            ]);
    }
}
