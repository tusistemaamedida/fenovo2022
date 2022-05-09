<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DescuentosViewExport;
use App\Exports\PresentacionesViewExport;
use App\Exports\ProductsViewExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\AddProduct;

use App\Http\Requests\Products\CalculatePrices;
use App\Imports\movementImport;
use App\Mail\NovedadMail;
use App\Models\Movement;

use App\Models\MovementProduct;
use App\Models\Product;
use App\Models\ProductDescuento;
use App\Models\ProductPrice;
use App\Models\Proveedor;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
                    return $product->stockReal(null, Auth::user()->store_active);
                })
                ->addColumn('senasa', function ($product) {
                    return $product->senasa();
                })
                ->addColumn('costo', function ($product) {
                    return '$' . $product->product_price->costfenovo;
                })
                ->addColumn('proveedor', function ($product) {
                    return $product->proveedor->name;
                })
                ->addColumn('historial', function ($producto) {
                    $ruta = 'getDataStockProduct(' . $producto->id . ",'" . route('getData.stock') . "')";
                    return '<a href="' . route('product.historial', ['id' => $producto->id]) . '"> <i class="fa fa-list" aria-hidden="true"></i> </a>';
                })
                ->addColumn('ajuste', function ($producto) {
                    $ruta = 'getDataStockProduct(' . $producto->id . ",'" . route('getData.stock') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-wrench" aria-hidden="true"></i> </a>';
                })
                ->addColumn('editar', function ($producto) {
                    return '<a class="btn-link" title="Editar" href="' . route('product.edit', ['id' => $producto->id]) . '"><i class="fa fa-edit"></i></a>';
                })
                ->addColumn('borrar', function ($producto) {
                    $ruta = 'destroy(' . $producto->id . ",'" . route('product.destroy') . "')";
                    return '<a class="btn-link confirm-delete" title="Delete" href="javascript:void(0)" onclick="' . $ruta . '"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['stock',  'borrar', 'editar', 'ajuste', 'costo','historial'])
                ->make(true);
        }

        return view('admin.products.list');
    }

    public function historial(Request $request){
        try {
            $product_id = $request->id;
            $producto   = $this->productRepository->getByIdWith($product_id);

            $movimientos = MovementProduct::where('product_id', $product_id)
                                          ->where('entidad_id',\Auth::user()->store_active)
                                          ->where('entidad_tipo','S')
                                          ->with('movement')->orderBy('created_at','DESC')->get();

            return view('admin.products.historial',compact('producto','movimientos'));
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
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
            $data['online_sale']  = isset($request->online_sale) ? 1 : 0;
            $data['iibb']         = isset($request->iibb) ? 1 : 0;
            $data['active']       = isset($request->active) ? 1 : 0;
            $preciosCalculados    = $this->calcularPrecios($request);
            $data                 = array_merge($data, $preciosCalculados);
            $producto_nuevo       = $this->productRepository->create($data);
            $data['product_id']   = $producto_nuevo->id;
            $this->productPriceRepository->create($data);

            Mail::to('novedades@frioteka.com')->bcc('cachoalbornoz@gmail.com')->send(new NovedadMail('producto creado'));

            return new JsonResponse(['type' => 'success', 'msj' => 'Producto agregado correctamente!']);
        } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error', 'msj' => $e->getMessage()]);
        }
    }

    public function getDataStock(Request $request)
    {
        try {
            $product = $this->productRepository->getByIdWith($request->id);
            if ($product) {
                $stock_presentaciones = [];
                $presentaciones       = explode('|', $product->unit_package);
                $stock_total          = $product->stockReal(null, \Auth::user()->store_active);

                for ($i = 0; $i < count($presentaciones); $i++) {
                    $bultos                                   = 0;
                    $presentacion                             = ($presentaciones[$i] == 0) ? 1 : $presentaciones[$i];
                    $stock                                    = $product->stockReal($presentacion, \Auth::user()->store_active);
                    $stock_presentaciones[$i]['presentacion'] = $presentacion;
                    $stock_presentaciones[$i]['unit_weight']  = $product->unit_weight;
                    $stock_presentaciones[$i]['stock']        = $stock;
                    // los bultos que hay disponibles se calcula dividiendo el balance por el peso del bulto
                    $peso_por_bulto = $product->unit_weight * $presentacion;

                    if ($stock) {
                        $bultos = $stock / $peso_por_bulto;
                    }
                    $stock_presentaciones[$i]['bultos'] = (int)$bultos;
                }
            }

            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.products.insertByAjax', compact('stock_presentaciones', 'product', 'presentaciones', 'stock_total'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function ajustarStock(Request $request)
    {
        try {
            $valida = false;
            $data   = $request->except('_token', 'product_id');

            foreach ($data as $item => $val) {
                if (!is_null($val)) {
                    $valida = true;
                }
            }

            if (!$valida) {
                return new JsonResponse(['msj' => 'Ingrese algún valor en el ajuste.', 'type' => 'error']);
            }

            if ($valida) {
                $from  = \Auth::user()->store_active;
                $count = Movement::where('from', $from)->where('type', 'AJUSTE')->count();
                $orden = ($count) ? $count + 1 : 1;

                $insert_data                   = [];
                $insert_data['type']           = 'AJUSTE';
                $insert_data['to']             = Auth::user()->store_active;
                $insert_data['date']           = now();
                $insert_data['from']           = Auth::user()->store_active;
                $insert_data['status']         = 'FINISHED';
                $insert_data['orden']          = $orden;
                $insert_data['voucher_number'] = time();
                $insert_data['flete']          = 0;
                $suma_balances                 = 0;
                $suma_stock                    = 0;

                foreach ($data as $item => $bultos) {
                    if (is_numeric($bultos)) {
                        $presentacion = (float)str_replace('_', ',', str_replace('unidades_', '', $item));

                        $producto = Product::where('id', $request->product_id)->first();
                        if ($producto) {
                            $balance_producto = $producto->stockReal(null, Auth::user()->store_active);
                            $entry            = $egress            = 0;
                            $new_balance      = $bultos * $presentacion * $producto->unit_weight;
                            $suma_balances += $new_balance;

                            if ($balance_producto < $new_balance) {
                                $entry = $new_balance;
                            } elseif ($balance_producto > $new_balance) {
                                $egress = $new_balance;
                            }

                            $movement               = Movement::create($insert_data);
                            $latest['balance']      = $suma_balances;
                            $latest['entidad_id']   = (Auth::user()->store_active) ? Auth::user()->store_active : 1;
                            $latest['entidad_tipo'] = 'S';
                            $latest['unit_package'] = $presentacion;
                            $latest['product_id']   = $request->product_id;
                            $latest['entry']        = $entry;
                            $latest['egress']       = $egress;
                            $latest['bultos']       = $bultos;
                            $latest['movement_id']  = $movement->id;
                            MovementProduct::create($latest);
                        }
                    }
                }
                return new JsonResponse(['msj' => 'Stock actualizado', 'type' => 'success']);
            }
            return new JsonResponse(['msj' => 'Error en el ajuste', 'type' => 'error']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
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

            //$productosProveedor         = Product::where('proveedor_id',$product->proveedor_id)->cursorPaginate(1);
            //dd($productosProveedor);

            $ofertas           = SessionOferta::where('product_id', $request->id)->get();
            $oferta            = ($request->has('fecha_oferta')) ? SessionOferta::where('id', $request->oferta_id)->first() : null;
            $alicuotas         = $this->alicuotaTypeRepository->get('value', 'DESC');
            $senasaDefinitions = $this->senasaDefinitionRepository->get('product_name', 'ASC');
            $categories        = $this->productCategoryRepository->getActives('name', 'ASC');
            $descuentos        = $this->productDescuentoRepository->getActives('descripcion', 'ASC');
            $proveedores       = $this->proveedorRepository->getActives('name', 'ASC');
            $unit_package      = explode('|', $product->unit_package);

            $productosProveedor = Product::where('proveedor_id', $product->proveedor_id)->paginate(1);

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
                $poferta                = SessionOferta::where('id', $oferta->id)->first()->toArray();
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
                        'ofertas',
                        'fecha_actualizacion_label',
                        'productosProveedor'
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

    public function update(CalculatePrices $request)
    {
        try {
            $data                 = $request->except('_token');
            $data['online_sale']  = isset($request->online_sale) ? 1 : 0;
            $data['iibb']         = isset($request->iibb) ? 1 : 0;
            $data['active']       = isset($request->active) ? 1 : 0;
            $product_id           = $data['product_id'];
            $data['unit_package'] = implode('|', $data['unit_package']);
            $producto_actualizado = $this->productRepository->fill($product_id, $data);

            $cod_descuento = $request->input('cod_descuento');
            $desc          = ProductDescuento::where('codigo', $cod_descuento)->first();
            $descp1        = ($request->has('descp1')) ? $request->input('descp1') : 0;
            if ((int)$product_id != 0) {
                $oferta = SessionOferta::where('product_id', $product_id)->first();
            }

            if ($desc && $desc->descuento > $descp1 && !$oferta && !isset($data['fecha_desde'], $data['fecha_hasta'])) {
                return new JsonResponse([
                    'type'   => 'error',
                    'descp1' => (int)$desc->descuento,
                    'msj'    => 'El descuento mayorista no debe ser menor al descuento por rubro aplicado: <br>' . $desc->descripcion, ]);
            }

            $preciosCalculados = $this->calcularPrecios($request);

            if ($preciosCalculados['type'] == 'error') {
                return new JsonResponse(['type' => 'error', 'msj' => $preciosCalculados['msj']]);
            }

            $data = array_merge($data, $preciosCalculados);
            $hoy  = \Carbon\Carbon::parse(now())->format('Y-m-d');
            if ($data['fecha_actualizacion_activa'] == 0 && is_null($data['fecha_desde']) && is_null($data['fecha_hasta']) && ($data['fecha_actualizacion'] == $hoy)) {
                $producto = $this->productRepository->getByIdWith($product_id);
                $this->productPriceRepository->fill($producto->product_price->id, $data);
                $tipo = 'actual';
            } else {
                if (isset($data['fecha_desde'], $data['fecha_hasta'])) {
                    $data['p2tienda'] = $data['p1tienda'];
                    if ($data['oferta_id'] > 0) {
                        SessionOferta::updateOrCreate(['product_id' => $data['product_id']], $data);
                    } else {
                        SessionOferta::updateOrCreate([
                            'product_id'  => $data['product_id'],
                            'fecha_desde' => $data['fecha_desde'],
                            'fecha_hasta' => $data['fecha_hasta'],
                        ], $data);
                    }

                    $tipo = ' de ofertas ';
                } elseif (!is_null($data['fecha_actualizacion']) && $data['fecha_actualizacion_activa'] == 0) {
                    $prices = SessionPrices::updateOrCreate(['product_id' => $data['product_id'], 'fecha_actualizacion' => $data['fecha_actualizacion']], $data);
                    $tipo   = ' de actualización ';
                } elseif (isset($data['fecha_actualizacion_activa']) && $data['fecha_actualizacion_activa'] != 0) {
                    $session_prices = SessionPrices::where('id', $data['fecha_actualizacion_activa'])->first();
                    $session_prices->fill($data);
                    $session_prices->save();
                    $tipo = ' de actualización ';
                }
            }

            Mail::to('novedades@frioteka.com')->bcc('cachoalbornoz@gmail.com')->send(new NovedadMail($tipo));

            return new JsonResponse(['type' => 'success', 'msj' => 'Precio ' . $tipo . ' modificado correctamente!']);
        } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error', 'msj' => $e->getMessage()]);
        }
    }

    public function updatePrices(Request $request)
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
            $preciosCalculados = $this->calcularPrecios($request);
            $data              = array_merge($data, $preciosCalculados);
            $data['p2tienda']  = $data['p1tienda'];
            $oferta            = SessionOferta::updateOrCreate(['product_id' => $data['product_id']], $data);

            return new JsonResponse([
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

    public function calculateProductPrices(Request $request)
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
            $validate       = ($request->has('validate')) ? (bool)$request->input('validate') : 1;
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
            $plist2     = $this->plist2($plist0Iva, $muplist2, $plist1);
            $comlista2  = $this->comlista2($plist0Iva, $plist2, $tasiva);
            $mup1       = $this->mup1($plist0Iva, $p1tienda);
            $p1may      = $this->p1may($p1tienda, $descp1);
            $mupp1may   = $this->mupp1may($p1may, $plist0Iva);
            $mup2       = $this->mup2($plist0Iva, $p2tienda);
            $p2may      = $p1may;
            $descp2     = $this->descp2($p2may, $p2tienda);
            $mupp2may   = $this->mupp2may($p2may, $plist0Iva);

            if (($p2tienda < $p1tienda) && $validate) {
                return ['type' => 'error', 'msj' => 'El precio tienda 2 no debe ser menor a la tienda 1'];
            }

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
            /*  $filepath = public_path('/imports/FROZEN.TXT');
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
             } */

            $filepath = public_path('/imports/ST.TXT');
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
                'type'           => 'AJUSTE',
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

            return redirect()->route('products.list');
        } catch (\Exception $e) {
            Log::info(json_encode($this->productImport));
        }
    }

    public function exportProductsToCsv()
    {
        (new ProductsViewExport())->store('producto.csv');
    }

    public function compararStock(Request $request)
    {

        /* Testing methods
        $producto = Product::whereId(1)->first();
        return $producto->salidaSemana();
        */


        if ($request->ajax()) {
            $productos = $this->productRepository->all()->where('active', '=', 1);

            return Datatables::of($productos)
                ->addIndexColumn()

                ->addColumn('proveedor', function ($product) {
                    return $product->proveedor->name;
                })

                ->addColumn('stockInicioSemana', function ($product) {
                    return $product->stockInicioSemana();
                })
                ->addColumn('ingresoSemana', function ($product) {
                    return number_format($product->ingresoSemana(),2);
                })
                ->addColumn('salidaSemana', function ($product) {
                    return number_format($product->salidaSemana(),2);
                })
                ->addColumn('stock', function ($product) {
                    return $product->stockReal(null, Auth::user()->store_active);
                })

                ->addColumn('costo', function ($product) {
                    return $product->product_price->plist0neto;
                })

                ->rawColumns(['stockInicioSemana', 'ingresoSemana', 'salidaSemana', 'stock'])
                ->make(true);
        }

        return view('admin.products.comparar');
    }

    public function exportDescuentosToCsv(Request $request)
    {
        return Excel::download(new DescuentosViewExport(), 'des.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportPresentacionesToCsv(Request $request)
    {
        return Excel::download(new PresentacionesViewExport($request), 'bultos.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function importProductsMovement(Request $request)
    {
        Excel::import(new movementImport(), $request->file('archivoMov')->store('temp'));
        return back();
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

    private function plist2($plist0Iva, $muplist2, $plist1)
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
