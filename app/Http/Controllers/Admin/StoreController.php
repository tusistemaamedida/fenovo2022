<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\StoreRepository;

class StoreController extends Controller
{
    private $storeRepository;

    public function __construct(StoreRepository $storeRepository){
        $this->storeRepository = $storeRepository;
    }

    public function list(){
        $stores = $this->storeRepository->paginate(20);
        return view('admin.stores.list', compact('stores'));
    }

    public function edit(Request $request){
        $store = $this->storeRepository->getOne($request->id);
        return $store;
    }
}
