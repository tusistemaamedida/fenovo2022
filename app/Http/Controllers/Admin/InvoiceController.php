<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    public function create(Request $request){
        try {
            $response = Http::post('http://127.0.0.1:3001/invoice?movement_id=512');
            $response->throw();
            dd($response);
        } catch (\Exception $e) {
            dd($e->getMessage());

        }

    }
}
