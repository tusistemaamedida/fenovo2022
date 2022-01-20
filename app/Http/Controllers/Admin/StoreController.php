<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Repositories\StoreRepository;
use App\Repositories\RegionRepository;
use App\Repositories\EnumRepository;

use App\Http\Requests\Stores\EditRequest;
use App\Models\Store;

class StoreController extends Controller
{
    private $storeRepository;
    private $regionRepository;

    public function __construct(StoreRepository $storeRepository, RegionRepository $regionRepository, EnumRepository $enumRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->regionRepository = $regionRepository;
        $this->enumRepository = $enumRepository;
    }

    public function list()
    {
        $stores = $this->storeRepository->paginate(20);
        return view('admin.stores.list', compact('stores'));
    }

    public function add()
    {
        $store      = null;
        $stores     = $this->storeRepository->getAll();
        $regiones   = $this->regionRepository->getAll();
        $states     = $this->enumRepository->getType('state');
        $printType  = $this->enumRepository->getType('print');
        $ivaType    = $this->enumRepository->getType('iva');
        return  view('admin.stores.form', compact('store', 'stores', 'regiones', 'states', 'printType', 'ivaType'));
    }

    public function store(EditRequest $request)
    {
        try {
            $data = $request->except(['_token']);
            $data['active'] = 1;
            $this->storeRepository->create($data);
            return new JsonResponse([
                'msj' => 'Actualización correcta !',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function edit(Request $request)
    {
        $store      = $this->storeRepository->getOne($request->id);
        $stores     = $this->storeRepository->getAll();
        $regiones   = $this->regionRepository->getAll();
        $states     = $this->enumRepository->getType('state');
        $printType  = $this->enumRepository->getType('print');
        $ivaType    = $this->enumRepository->getType('iva');
        return  view('admin.stores.form', compact('store', 'stores', 'regiones', 'states', 'printType', 'ivaType'));
    }

    public function update(EditRequest $request)
    {
        try {
            $data = $request->except(['_token', 'store_id', 'active', 'online_sale']);
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $data['online_sale'] = ($request->has('online_sale')) ? 1 : 0;
            $stores = $this->storeRepository->update($request->input('store_id'), $data);
            return new JsonResponse([
                'msj' => 'Actualización correcta !',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Store $store)
    {
        $data['active'] = 0;
        $this->storeRepository->update($store->id, $data);
        return redirect()->route('stores.list');
    }
}
