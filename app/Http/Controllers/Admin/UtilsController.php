<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Artisan;

/*
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/
class UtilsController extends Controller
{
    public function clean(){

        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('optimize');
        return Artisan::output();
    }
}

?>
