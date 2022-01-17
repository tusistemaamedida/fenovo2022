<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Repositories\CustomerRepository;
use App\Repositories\StoreRepository;
use App\Repositories\EnumRepository;

use App\Http\Requests\Customers\EditRequest;

class CustomerController extends Controller
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository, StoreRepository $storeRepository, EnumRepository $enumRepository){
        $this->customerRepository   = $customerRepository;
        $this->storeRepository      = $storeRepository;
        $this->enumRepository = $enumRepository;
    }

    public function list(){
        $customers = $this->customerRepository->paginate(20);
        return view('admin.customers.list', compact('customers'));
    }

    public function edit(Request $request){
        try {
            $customer   = $this->customerRepository->getOne($request->id);
            $stores     = $this->storeRepository->getActives();
            $states     = $this->enumRepository->getType('state');
            $ivaType    = $this->enumRepository->getType('iva');
            $listPrices = $this->enumRepository->getType('price');
            return new JsonResponse([
                'type'=>'success',
                'html' => view('admin.customers.insertByAjax',compact('customer', 'stores', 'ivaType', 'states', 'listPrices'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }

    public function update(EditRequest $request){
        try {
            $data = $request->except(['_token','customer_id','active']);
            $data['active'] = ($request->has('active'))?1:0;
            $customers = $this->customerRepository->update($request->input('customer_id'),$data);
            return new JsonResponse([
                'msj'=>'Actualización correcta !',
                'type'=>'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }
}
