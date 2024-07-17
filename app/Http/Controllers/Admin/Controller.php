<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use ValidatesRequests;
	
	function __construct()
	{
		$this->middleware('auth');
	}
}
