<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MovementsViewExport;

use App\Http\Controllers\Controller;
use App\Models\Exportaciones;
use App\Repositories\CustomerRepository;
use App\Repositories\EnumRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SessionProductRepository;
use App\Repositories\StoreRepository;

use App\Traits\OriginDataTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class SettingController extends Controller
{
    private $customerRepository;
    private $storeRepository;
    private $productRepository;
    private $sessionProductRepository;

    use OriginDataTrait;

    public function __construct(
        CustomerRepository $customerRepository,
        StoreRepository $storeRepository,
        ProductRepository $productRepository,
        SessionProductRepository $sessionProductRepository,
        EnumRepository $enumRepository
    ) {
        $this->productRepository        = $productRepository;
        $this->customerRepository       = $customerRepository;
        $this->storeRepository          = $storeRepository;
        $this->sessionProductRepository = $sessionProductRepository;
        $this->enumRepository           = $enumRepository;
    }

    public function menuSetting(Request $request)
    {
        $tiposalidas = $this->enumRepository->getType('movimientos');
        $stores      = $this->storeRepository->getActives();
        return view('admin.setting.menu', compact('tiposalidas', 'stores'));
    }
}
