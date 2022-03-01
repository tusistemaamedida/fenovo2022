<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\EditRequest;
use App\Models\Customer;

use App\Repositories\CustomerRepository;
use App\Repositories\EnumRepository;
use App\Repositories\StoreRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository, StoreRepository $storeRepository, EnumRepository $enumRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->storeRepository    = $storeRepository;
        $this->enumRepository     = $enumRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->rol() == 'superadmin' || Auth::user()->rol() == 'admin') {
                $customer = Customer::all();
            } else {
                $store_active = Auth::user()->store_active;
                $customer = Customer::where('store_id', $store_active)->get();
            }

            return Datatables::of($customer)
                ->addIndexColumn()
                ->addColumn('tienda', function ($customer) {
                    return $customer->store->description;
                })
                ->addColumn('inactivo', function ($customer) {
                    return ($customer->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($customer) {
                    $ruta = 'edit(' . $customer->id . ",'" . route('customers.edit') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($customer) {
                    $ruta = 'destroy(' . $customer->id . ",'" . route('customers.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['tienda', 'inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.customers.index');
    }

    public function add()
    {
        try {
            $customer   = null;
            $stores     = $this->storeRepository->getActives();
            $states     = $this->enumRepository->getType('state');
            $ivaType    = $this->enumRepository->getType('iva');
            $listPrices = $this->enumRepository->getType('price');
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.customers.insertByAjax', compact('customer', 'stores', 'ivaType', 'states', 'listPrices'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(EditRequest $request)
    {
        try {
            $data           = $request->except(['_token', 'active']);
            $data['active'] = 1;
            $customers      = $this->customerRepository->create($data);
            return new JsonResponse([
                'msj'  => 'Actualización correcta !',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function edit(Request $request)
    {
        try {
            $customer   = $this->customerRepository->getOne($request->id);
            $stores     = $this->storeRepository->getActives();
            $states     = $this->enumRepository->getType('state');
            $ivaType    = $this->enumRepository->getType('iva');
            $listPrices = $this->enumRepository->getType('price');
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.customers.insertByAjax', compact('customer', 'stores', 'ivaType', 'states', 'listPrices'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(EditRequest $request)
    {
        try {
            $data           = $request->except(['_token', 'customer_id', 'active']);
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $customers      = $this->customerRepository->update($request->input('customer_id'), $data);
            return new JsonResponse([
                'msj'  => 'Actualización correcta !',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        $this->customerRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
