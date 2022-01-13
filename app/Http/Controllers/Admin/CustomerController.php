<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CustomerRepository;

class CustomerController extends Controller
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository){
        $this->customerRepository = $customerRepository;
    }

    public function list(){
        $customers = $this->customerRepository->paginate(20);
        return view('admin.customers.list', compact('customers'));
    }
}
