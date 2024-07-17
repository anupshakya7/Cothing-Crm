<?php 

use Carbon\Carbon;

if (! function_exists('theme')) {
	function theme($path)
	{
		$config = app('config')->get('cms.theme');

		return url($config['folder'].'/'.$config['active'].'/assets/'.$path);
	}
}

function getPosts($block)
{
	if ($block->filter=='category') {
		return $posts = App\Post::with('author')->where('published_at', '<', Carbon::now())->where('category_id', $block->category_id)->take($block->limit)->orderBy('published_at', 'desc')->get();
	} elseif ($block->filter=='random') {
		return $posts = App\Post::with('author')->inRandomOrder()->where('published_at', '<', Carbon::now())->take($block->limit)->orderBy('published_at', 'desc')->get();
	} else {
		return $posts = App\Post::with('author')->where('published_at', '<', Carbon::now())->take($block->limit)->orderBy('published_at', 'desc')->get();
	}
}