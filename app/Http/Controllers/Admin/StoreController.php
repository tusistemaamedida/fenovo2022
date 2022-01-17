<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Repositories\StoreRepository;
use App\Repositories\RegionRepository;
use App\Repositories\EnumRepository;

use App\Http\Requests\Stores\AddRequest;

class StoreController extends Controller
{
    private $storeRepository;
    private $regionRepository;

    public function __construct(StoreRepository $storeRepository, RegionRepository $regionRepository, EnumRepository $enumRepository){
        $this->storeRepository = $storeRepository;
        $this->regionRepository = $regionRepository;
        $this->enumRepository = $enumRepository;
    }

    public function list(){
        $stores = $this->storeRepository->paginate(20);
        return view('admin.stores.list', compact('stores'));
    }

    public function edit(Request $request){
        try {
            $stores     = $this->storeRepository->getAll();
            $regiones   = $this->regionRepository->getAll();
            $store      = $this->storeRepository->getOne($request->id);
            $states     = $this->enumRepository->getType('state');
            $printType  = $this->enumRepository->getType('print');
            $ivaType    = $this->enumRepository->getType('iva');
            return new JsonResponse([
                'type'=>'success',
                'html' => view('admin.stores.insertByAjax',compact('store','stores', 'regiones', 'states', 'printType', 'ivaType'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }

    public function update(AddRequest $request){
        try {
            $data = $request->except(['_token','store_id','active', 'online_sale']);
            $data['active'] = ($request->has('active'))?1:0;
            $data['online_sale'] = ($request->has('online_sale'))?1:0;
            $stores = $this->storeRepository->update($request->input('store_id'),$data);
            return new JsonResponse([
                'msj'=>'Actualización correcta !',
                'type'=>'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }
}
