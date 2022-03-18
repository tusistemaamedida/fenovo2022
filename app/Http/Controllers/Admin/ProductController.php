<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsViewExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\AddProduct;

use App\Http\Requests\Products\CalculatePrices;
use App\Http\Requests\Products\UpdateProduct;

use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Product;
use App\Models\ProductDescuento;
use App\Models\ProductPrice;
use App\Models\SessionOferta;
use App\Models\SessionPrices;

use App\Repositories\AlicuotaTypeRepository;
use App\Repositories\ProducDescuentoRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductPriceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProveedorRepository;

use App\Repositories\SenasaDefinitionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    private $productRepository;
    private $productPriceRepository;
    private $alicuotaTypeRepository;
    private $productCategoryRepository;
    private $productDescuentoRepository;
    private $proveedorRepository;
    private $senasaDefinitionRepository;
    private $productImport;

    public function __construct(
        ProductRepository $productRepository,
        ProductPriceRepository $productPriceRepository,
        ProductCategoryRepository $productCategoryRepository,
        ProducDescuentoRepository $productDescuentoRepository,
        ProveedorRepository $proveedorRepository,
        SenasaDefinitionRepository $senasaDefinitionRepository,
        AlicuotaTypeRepository $alicuotaTypeRepository
    ) {
        $this->productRepository          = $productRepository;
        $this->productPriceRepository     = $productPriceRepository;
        $this->alicuotaTypeRepository     = $alicuotaTypeRepository;
        $this->productCategoryRepository  = $productCategoryRepository;
        $this->productDescuentoRepository = $productDescuentoRepository;
        $this->proveedorRepository        = $proveedorRepository;
        $this->senasaDefinitionRepository = $senasaDefinitionRepository;
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $productos = $this->productRepository->all()->where('active', '=', 1);
            return Datatables::of($productos)
                ->addIndexColumn()

                ->addColumn('stock', function ($product) {
                    return $product->stock(null, Auth::user()->store_active);
                })
                ->addColumn('senasa', function ($product) {
                    return $product->senasa();
                })
                ->addColumn('proveedor', function ($product) {
                    return $product->proveedor->name;
                })
                ->addColumn('editar', function ($producto) {
                    return '<a class="btn-link" title="Editar" href="' . route('product.edit', ['id' => $producto->id]) . '"><i class="fa fa-edit"></i></a>';
                })
                ->addColumn('borrar', function ($producto) {
                    $ruta = 'destroy(' . $producto->id . ",'" . route('product.destroy') . "')";
                    return '<a class="btn-link confirm-delete" title="Delete" href="javascript:void(0)" onclick="' . $ruta . '"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['stock', 'senasa', 'borrar', 'editar'])
                ->make(true);
        }

        return view('admin.products.list');
    }

    public function add()
    {
        $alicuotas         = $this->alicuotaTypeRepository->get('value', 'DESC');
        $senasaDefinitions = $this->senasaDefinitionRepository->get('product_name', 'DESC');
        $categories        = $this->productCategoryRepository->getActives('name', 'ASC');
        $descuentos        = $this->productDescuentoRepository->getActives('codigo', 'ASC');
        $proveedores       = $this->proveedorRepository->getActives('name', 'ASC');
        return view('admin.products.add', compact('alicuotas', 'categories', 'descuentos', 'proveedores', 'senasaDefinitions'));
    }

    public function store(AddProduct $request)
    {
        try {
            $data                 = $request->all();
            $data['unit_package'] = implode('|', $data['unit_package']);
            $preciosCalculados    = $this->calcularPrecios($request);
            $data                 = array_merge($data, $preciosCalculados);
            $producto_nuevo       = $this->productRepository->create($data);
            $data['product_id']   = $producto_nuevo->id;
            $this->productPriceRepository->create($data);
            return new JsonResponse(['type' => 'success', 'msj' => 'Producto agregado correctamente!']);
        } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error', 'msj' => $e->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        try {
            $fecha_actualizacion_label  = '';
            $fecha_actualizacion        = null;
            $fecha_actualizacion_activa = ($request->has('fecha_actualizacion_activa')) ? $request->input('fecha_actualizacion_activa') : 0;
            $fecha_oferta               = $request->input('fecha_oferta');
            $product                    = $this->productRepository->getByIdWith($request->id);
            $oferta                     = SessionOferta::where('product_id', $request->id)->first();
            $alicuotas                  = $this->alicuotaTypeRepository->get('value', 'DESC');
            $senasaDefinitions          = $this->senasaDefinitionRepository->get('product_name', 'ASC');
            $categories                 = $this->productCategoryRepository->getActives('name', 'ASC');
            $descuentos                 = $this->productDescuentoRepository->getActives('descripcion', 'ASC');
            $proveedores                = $this->proveedorRepository->getActives('name', 'ASC');
            $unit_package               = explode('|', $product->unit_package);

            if ($fecha_actualizacion_activa) {
                $pp1                       = $product->product_price->toArray();
                $ppsession                 = SessionPrices::where('id', $fecha_actualizacion_activa)->first()->toArray();
                $fecha_actualizacion_label = \Carbon\Carbon::parse($ppsession['fecha_actualizacion'])->format('d/m/Y');
                $fecha_actualizacion       = $ppsession['fecha_actualizacion'];
                $new_prices                = array_replace($pp1, $ppsession);
                $product->product_price    = new ProductPrice($new_prices);
            }

            if ($fecha_oferta) {
                $pp1                    = $product->product_price->toArray();
                $poferta                = SessionOferta::where('id', $fecha_oferta)->first()->toArray();
                $new_prices             = array_replace($pp1, $poferta);
                $product->product_price = new ProductPrice($new_prices);
            }

            if ($product) {
                return view(
                    'admin.products.edit',
                    compact(
                        'alicuotas',
                        'categories',
                        'descuentos',
                        'proveedores',
                        'senasaDefinitions',
                        'fecha_actualizacion',
                        'product',
                        'unit_package',
                        'fecha_actualizacion_activa',
                        'oferta',
                        'fecha_actualizacion_label'
                    )
                );
            }
            $notification = [
                'message'    => 'El producto no existe !',
                'alert-type' => 'error',
            ];
            return redirect()->route('products.list')->with($notification);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(UpdateProduct $request)
    {
        try {
            $data                 = $request->except('_token');
            $product_id           = $data['product_id'];
            $data['unit_package'] = implode('|', $data['unit_package']);
            $producto_actualizado = $this->productRepository->fill($product_id, $data);
            $preciosCalculados    = $this->calcularPrecios($request);
            $data                 = array_merge($data, $preciosCalculados);
            if ($data['fecha_actualizacion_activa'] == 0) {
                $producto = $this->productRepository->getByIdWith($product_id);
                $this->productPriceRepository->fill($producto->product_price->id, $data);
            } else {
                $session_prices = SessionPrices::where('id', $data['fecha_actualizacion_activa'])->first();
                $session_prices->fill($data);
                $session_prices->save();
            }
            return new JsonResponse(['type' => 'success', 'msj' => 'Producto actualizado correctamente!']);
        } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error', 'msj' => $e->getMessage()]);
        }
    }

    public function updatePrices(CalculatePrices $request)
    {
        try {
            $data              = $request->except('_token');
            $product_id        = $data['product_id'];
            $preciosCalculados = $this->calcularPrecios($request);
            $data              = array_merge($data, $preciosCalculados);
            $prices            = SessionPrices::updateOrCreate(['product_id' => $data['product_id'], 'fecha_actualizacion' => $data['fecha_actualizacion']], $data);
            $divFechasPrecios  = "<a href='javascript:void(0)'><span class='badge  badge-primary p-2'>" . \Carbon\Carbon::parse($prices->fecha_actualizacion)->format('d/m/Y') . '</span></a>';
            return new JsonResponse(['type' => 'success',
                'msj'                       => 'Los precios se actualizarán el ' . \Carbon\Carbon::parse($prices->fecha_actualizacion)->format('d/m/Y'),
                'divFechasPrecios'          => $divFechasPrecios, ]);
        } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error', 'msj' => $e->getMessage()]);
        }
    }

    public function updateOferta(CalculatePrices $request)
    {
        try {
            $data              = $request->except('_token');
            $product           = $this->productRepository->getByIdWith($request->product_id);
            $preciosCalculados = $this->calcularPrecios($request);
            $data              = array_merge($data, $preciosCalculados);
            $data['p2tienda']  = $data['p1tienda'];
            $oferta            = SessionOferta::updateOrCreate(['product_id' => $data['product_id']], $data);

            return new JsonResponse([
                'divPanel'  => view('admin.products.panel', compact('product', 'oferta'))->render(),
                'divOferta' => view('admin.products.oferta', compact('oferta'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error', 'msj' => $e->getMessage()]);
        }
    }

    public function validateCode(Request $request)
    {
        $data = $request->all();
        if ($data['cod_fenovo'] == '') {
            return new JsonResponse(['msj' => 'Ingrese un Código Fenovo', 'type' => 'error']);
        }
        if ($this->productRepository->existCode($data['cod_fenovo'])) {
            return new JsonResponse(['msj' => 'El Código Fenovo ingresado ya existe', 'type' => 'error']);
        }
        return new JsonResponse(['msj' => 'Ok', 'type' => 'success']);
    }

    public function getDescuentoAplicado(Request $request)
    {
        $cod_descuento = $request->input('cod_descuento');
        $desc          = ProductDescuento::where('codigo', $cod_descuento)->first();
        if ($desc) {
            return new JsonResponse(['type' => 'success', 'descp1' => (int)$desc->descuento]);
        }
        return new JsonResponse(['type' => 'success', 'descp1' => 0]);
    }

    public function calculateProductPrices(CalculatePrices $request)
    {
        $oferta        = null;
        $cod_descuento = $request->input('cod_descuento');
        $desc          = ProductDescuento::where('codigo', $cod_descuento)->first();
        $descp1        = ($request->has('descp1')) ? $request->input('descp1') : 0;
        if ((int)$request->input('product_id') != 0) {
            $oferta = SessionOferta::where('product_id', $request->input('product_id'))->first();
        }

        if ($desc && $desc->descuento > $descp1 && !$oferta) {
            return new JsonResponse([
                'type'   => 'error',
                'descp1' => (int)$desc->descuento,
                'msj'    => 'El descuento mayorista no debe ser menor al descuento por rubro aplicado: <br>' . $desc->descripcion, ]);
        }
        $array_prices = $this->calcularPrecios($request);
        if ($request->ajax()) {
            return new JsonResponse($array_prices);
        }
        return $array_prices;
    }

    private function calcularPrecios($request)
    {
        try {
            $plistproveedor = ($request->has('plistproveedor')) ? $request->input('plistproveedor') : 0;
            $descproveedor  = ($request->has('descproveedor')) ? $request->input('descproveedor') : 0;

            $mupfenovo         = ($request->has('mupfenovo')) ? $request->input('mupfenovo') : 0;
            $contribution_fund = ($request->has('contribution_fund')) ? $request->input('contribution_fund') : 0;

            $tasiva   = ($request->has('tasiva')) ? $request->input('tasiva') * 100 : 21;
            $muplist1 = ($request->has('muplist1')) ? $request->input('muplist1') : 0;
            $muplist2 = ($request->has('muplist2')) ? $request->input('muplist2') : 0;
            $p1tienda = ($request->has('p1tienda')) ? $request->input('p1tienda') : 0;
            $descp1   = ($request->has('descp1')) ? $request->input('descp1') : 0;
            $p2tienda = ($request->has('p2tienda')) ? $request->input('p2tienda') : 0;
            $descp2   = ($request->has('descp2')) ? $request->input('descp2') : 0;

            $costFenovo = $this->costFenovo($plistproveedor, $descproveedor);
            $plist0Neto = $this->plist0Neto($costFenovo, $mupfenovo, $contribution_fund);
            $plist0Iva  = $this->plist0Iva($plist0Neto, $tasiva);
            $plist1     = $this->plist1($plist0Iva, $muplist1);
            $comlista1  = $this->comlista1($plist0Iva, $plist1, $tasiva);
            $plist2     = $this->plist2($plist0Iva, $muplist2);
            $comlista2  = $this->comlista2($plist0Iva, $plist2, $tasiva);
            $mup1       = $this->mup1($plist0Iva, $p1tienda);
            $p1may      = $this->p1may($p1tienda, $descp1);
            $mupp1may   = $this->mupp1may($p1may, $plist0Iva);
            $mup2       = $this->mup2($plist0Iva, $p2tienda);
            $p2may      = $p1may;
            $descp2     = $this->descp2($p2may, $p2tienda);
            $mupp2may   = $this->mupp2may($p2may, $plist0Iva);

            return [
                'type'       => 'success',
                'msj'        => 'ok',
                'costfenovo' => $costFenovo,
                'plist0neto' => $plist0Neto,
                'plist0iva'  => $plist0Iva,
                'plist1'     => $plist1,
                'comlista1'  => $comlista1,
                'plist2'     => $plist2,
                'comlista2'  => $comlista2,
                'mup1'       => $mup1,
                'p1may'      => $p1may,
                'mupp1may'   => $mupp1may,
                'mup2'       => $mup2,
                'p2may'      => $p2may,
                'mupp2may'   => $mupp2may,
                'tasiva'     => $tasiva,
                'descp2'     => $descp2,
            ];
        } catch (\Exception $th) {
            return ['type' => 'error', 'msj' => $th->getMessage()];
        }
    }

    public function destroy(Request $request)
    {
        Product::find($request->id)->update(['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }

    public function getProductByProveedor(Request $request)
    {
        try {
            $productos = $this->productRepository->getByProveedorIdPluck($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalle', compact('productos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function importFromCsv()
    {
        try {
            $filepath = public_path('/imports/FROZEN.TXT');
            $file     = fopen($filepath, 'r');

            $importData_arr = [];
            $i              = 0;

            while (($filedata = fgetcsv($file, 0, ',')) !== false) {
                $num = count($filedata);
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }

            fclose($file);
            foreach ($importData_arr as $importData) {
                $data       = [];
                $proveedor  = $this->proveedorRepository->getByName($importData[2]);
                $insertData = [
                    'cod_fenovo'    => $importData[0],
                    'cod_proveedor' => $importData[1],
                    'name'          => $importData[3],
                    'proveedor_id'  => $proveedor->id,
                    'categorie_id'  => 1,
                    'barcode'       => $importData[16],
                    'unit_type'     => $importData[18],
                    'unit_weight'   => $importData[19],
                    'unit_package'  => $importData[17],
                    'package_palet' => $importData[22],
                    'package_row'   => $importData[23],
                    'cod_descuento' => ($importData[24] != '' && !is_null($importData[24])) ? $importData[24] : null,
                ];
                $this->productImport = $insertData;
                $producto_nuevo      = $this->productRepository->create($insertData);

                $importData[8]  = ((int)$importData[8] == 0) ? 1 : $importData[8];
                $importData[12] = ((int)$importData[12] == 0) ? 1 : $importData[12];
                $importData[15] = ((int)$importData[15] == 0) ? 1 : $importData[15];
                $importData[21] = ((int)$importData[21] == 0) ? 1 : $importData[21];

                $plist1 = round($importData[8] * ($importData[15] / 100 + 1) * (10 / 100 + 1), 2);
                $plist2 = round($importData[8] * ($importData[15] / 100 + 1) * (20 / 100 + 1), 2);

                $plist1 = ((int)$plist1 == 0) ? 1 : $plist1;
                $plist2 = ((int)$plist2 == 0) ? 1 : $plist2;

                $data = [
                    'product_id'        => $producto_nuevo->id,
                    'plistproveedor'    => $importData[4],
                    'descproveedor'     => $importData[5],
                    'costfenovo'        => $importData[6],
                    'mupfenovo'         => $importData[7],
                    'tasiva'            => $importData[15],
                    'plist0neto'        => $importData[8],
                    'plist0iva'         => $importData[8] * ($importData[15] / 100 + 1),
                    'contribution_fund' => 0.5,

                    'p1tienda' => $importData[10],
                    'mup1'     => $importData[9],
                    'mupp1may' => $importData[11],
                    'descp1'   => $importData[14],
                    'p1may'    => $importData[12],
                    'muplist1' => 10,
                    'muplist2' => 20,

                    'plist1'    => $plist1,
                    'plist2'    => $plist2,
                    'comlista1' => round((($plist1 - $importData[8] * ($importData[15] / 100 + 1)) / ($importData[15] / 100 + 1) * 100) / $plist1, 2),
                    'comlista2' => round((($plist2 - $importData[8] * ($importData[15] / 100 + 1)) / ($importData[15] / 100 + 1) * 100) / $plist2, 2),

                    'p2tienda' => $importData[21],
                    'mup2'     => $importData[20],
                    'p2may'    => $importData[12],
                    'descp2'   => abs((($importData[12] - $importData[21]) * 100) / $importData[21]),
                    'mupp2may' => round(($importData[12] / ($importData[8] * ($importData[15] / 100 + 1)) - 1) * 100, 2),

                    'cantmay1' => $importData[13],
                    'cantmay2' => $importData[13],
                ];
                $this->productPriceRepository->create($data);
            }

            /* $filepath = public_path('/imports/ST.TXT');
            $file     = fopen($filepath, 'r');

            $importData_arr2 = [];
            $i               = 0;

            while (($filedata2 = fgetcsv($file, 0, ',')) !== false) {
                $num = count($filedata2);
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr2[$i][] = $filedata2[$c];
                }
                $i++;
            }
            fclose($file);

            $movement = Movement::create([
                'date'           => now(),
                'type'           => 'COMPRA',
                'from'           => 1,
                'to'             => 1,
                'status'         => 'CREATED',
                'voucher_number' => '00001',
            ]);
            $code_not_found = [];
            foreach ($importData_arr2 as $importData) {
                $cod_fenovo = $importData[0];
                $balance    = $importData[1];
                $product    = $this->productRepository->getByCodeFenovo($cod_fenovo);
                if ($product) {
                    MovementProduct::create([
                        'entidad_id'   => 1,
                        'entidad_tipo' => 'S',
                        'movement_id'  => $movement->id,
                        'product_id'   => $product->id,
                        'unit_package' => $product->unit_package,
                        'invoice'      => 1,
                        'entry'        => $balance,
                        'egress'       => 0,
                        'balance'      => $balance,
                        'unit_price'   => $product->product_price->costfenovo,
                        'tasiva'       => $product->product_price->tasiva,
                    ]);
                } else {
                    array_push($code_not_found, $cod_fenovo);
                }
            }
            dd($code_not_found);
             */
            return redirect()->route('products.list');
        } catch (\Exception $e) {
            Log::info(json_encode($this->productImport));
        }
    }

    public function exportProductsToCsv(Request $request)
    {
        return Excel::download(new ProductsViewExport($request), 'producto.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    private function descp2($p2may, $p2tienda)
    {
        try {
            $p2tienda = ($p2tienda) ? $p2tienda : 1;
            return abs(round(((($p2may - $p2tienda) * 100) / $p2tienda), 2));
        } catch (\Exception $e) {
            throw new \Exception('descp2 ' . $e->getMessage());
        }
    }

    private function mupp2may($p2may, $plist0Iva)
    {
        try {
            return round(($p2may / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw new \Exception('mupp2may ' . $e->getMessage());
        }
    }

    private function p2may($p2tienda, $descp2)
    {
        try {
            return round($p2tienda - $p2tienda * ($descp2 / 100), 2);
        } catch (\Exception $e) {
            throw new \Exception('p2may ' . $e->getMessage());
        }
    }

    private function mup2($plist0Iva, $p2tienda)
    {
        try {
            return round(($p2tienda / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw new \Exception('mup2 ' . $e->getMessage());
        }
    }

    private function mupp1may($p1may, $plist0Iva)
    {
        try {
            return round(($p1may / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw new \Exception('mupp1may ' . $e->getMessage());
        }
    }

    private function p1may($p1tienda, $descp1)
    {
        try {
            return round($p1tienda - $p1tienda * ($descp1 / 100), 2);
        } catch (\Exception $e) {
            throw new \Exception('p1may ' . $e->getMessage());
        }
    }

    private function mup1($plist0Iva, $p1tienda)
    {
        try {
            return round(($p1tienda / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw new \Exception('mup1 ' . $e->getMessage());
        }
    }

    private function costFenovo($plistproveedor, $descproveedor)
    {
        try {
            return round($plistproveedor - $plistproveedor * ($descproveedor / 100), 2);
        } catch (\Exception $e) {
            throw new \Exception('costFenovo ' . $e->getMessage());
        }
    }

    private function plist0Neto($costFenovo, $mupfenovo, $contribution_fund)
    {
        try {
            return round($costFenovo * ($mupfenovo / 100 + 1) * ($contribution_fund / 100 + 1), 2);
        } catch (\Exception $e) {
            throw new \Exception('plist0Neto ' . $e->getMessage());
        }
    }

    private function plist0Iva($plist0Neto, $tasiva)
    {
        try {
            return round($plist0Neto * ($tasiva / 100 + 1), 2);
        } catch (\Exception $e) {
            throw new \Exception('plist0Iva ' . $e->getMessage());
        }
    }

    private function plist1($plist0Iva, $muplist1)
    {
        try {
            return round($plist0Iva * ($muplist1 / 100 + 1), 2);
        } catch (\Exception $e) {
            throw new \Exception('plist1 ' . $e->getMessage());
        }
    }

    private function comlista1($plist0Iva, $plist1, $tasiva)
    {
        try {
            return round((($plist1 - $plist0Iva) / ($tasiva / 100 + 1) * 100) / $plist1, 2);
        } catch (\Exception $e) {
            throw new \Exception('comlista1 ' . $e->getMessage());
        }
    }

    private function plist2($plist0Iva, $muplist2)
    {
        try {
            return round($plist0Iva * ($muplist2 / 100 + 1), 2);
        } catch (\Exception $e) {
            throw new \Exception('plist2 ' . $e->getMessage());
        }
    }

    private function comlista2($plist0Iva, $plist2, $tasiva)
    {
        try {
            return round((($plist2 - $plist0Iva) / ($tasiva / 100 + 1)) * 100 / $plist2, 2);
        } catch (\Exception $e) {
            throw new \Exception('comlista2 ' . $e->getMessage());
        }
    }
}
