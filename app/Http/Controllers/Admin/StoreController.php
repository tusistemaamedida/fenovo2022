<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stores\EditRequest;
use App\Models\Store;

use App\Repositories\EnumRepository;
use App\Repositories\RegionRepository;
use App\Repositories\StoreRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StoreController extends Controller
{
    private $storeRepository;
    private $regionRepository;

    public function __construct(StoreRepository $storeRepository, RegionRepository $regionRepository, EnumRepository $enumRepository)
    {
        $this->storeRepository  = $storeRepository;
        $this->regionRepository = $regionRepository;
        $this->enumRepository   = $enumRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->rol() == 'superadmin' || Auth::user()->rol() == 'admin') {
                $store = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->get();
            } else {
                $store = Auth::user()->stores;
            }
            return Datatables::of($store)
                ->addIndexColumn()
                ->addColumn('cod_fenovo', function ($store) {
                    return str_pad($store->cod_fenovo, 4, 0, STR_PAD_LEFT);
                })
                ->addColumn('inactivo', function ($store) {
                    return ($store->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($store) {
                    return '<a href="' . route('stores.edit', ['id' => $store->id]) . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($store) {
                    $ruta = 'destroy(' . $store->id . ",'" . route('stores.destroy') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['cod_fenovo', 'inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.stores.index');
    }

    public function add()
    {
        $store     = null;
        $regiones  = $this->regionRepository->getAll();
        $states    = $this->enumRepository->getType('state');
        $storeType = $this->enumRepository->getType('store');
        $printType = $this->enumRepository->getType('print');
        $ivaType   = $this->enumRepository->getType('iva');
        return  view('admin.stores.form', compact('store', 'regiones', 'states', 'printType', 'ivaType', 'storeType'));
    }

    public function store(EditRequest $request)
    {
        $data           = $request->except(['_token']);
        $data['active'] = 1;
        $data['online_sale'] = ($request->has('online_sale')) ? 1 : 0;
        $data['habilitado_panama'] = ($request->has('habilitado_panama')) ? 1 : 0;
        $this->storeRepository->create($data);
        return redirect()->route('stores.index');
    }

    public function edit(Request $request)
    {
        $store     = $this->storeRepository->getOne($request->id);
        $regiones  = $this->regionRepository->getAll();
        $states    = $this->enumRepository->getType('state');
        $storeType = $this->enumRepository->getType('store');
        $printType = $this->enumRepository->getType('print');
        $ivaType   = $this->enumRepository->getType('iva');
        return  view('admin.stores.form', compact('store', 'regiones', 'states', 'printType', 'ivaType', 'storeType'));
    }

    public function update(EditRequest $request)
    {
        $data                = $request->except(['_token', 'store_id', 'active', 'online_sale']);
        $data['active']      = ($request->has('active')) ? 1 : 0;
        $data['online_sale'] = ($request->has('online_sale')) ? 1 : 0;
        $data['habilitado_panama'] = ($request->has('habilitado_panama')) ? 1 : 0;
        $this->storeRepository->update($request->input('store_id'), $data);
        return redirect()->route('stores.index');
    }

    public function destroy(Request $request)
    {
        $this->storeRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
