<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    public function create(Request $request){
        try {
            $response = Http::post('https://afip.fenovo.ar/invoice?movement_id=515');
            $response->throw();
            dd($response);
        } catch (\Exception $e) {
            dd($e->getMessage());

        }

    }
}
