<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Products\CalculatePrices;
use App\Repositories\ProductPriceRepository;
use App\Models\Product;
use App\Models\ProductDescuento;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use App\Models\Proveedor;
use App\Models\SessionOferta;
use App\Models\SessionPrices;
use App\Repositories\AlicuotaTypeRepository;
use App\Repositories\EnumRepository;
use App\Repositories\ProducDescuentoRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProveedorRepository;
use App\Repositories\SenasaDefinitionRepository;

use App\Http\Controllers\Admin\ProductController;

class ProductNoCongeladosController extends ProductController
{
    public function list(Request $request){
        if ($request->ajax()) {
            $categorieIdBetween = [4,8];

            $productos = DB::table('products as t1')
                            ->where('t1.active', 1)
                            ->whereBetween('t1.categorie_id', $categorieIdBetween)
                            ->join('product_prices as t2', 't1.id', '=', 't2.product_id')
                            ->join('product_categories as categ', 'categ.id', '=', 't1.categorie_id')
                            ->join('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
                            ->select(['t1.id', 't1.cod_fenovo', 't1.name', 't1.unit_type', 't2.costfenovo', 'categ.abrev as categoria', 't3.name as proveedor'])
                            ->orderBy('t1.cod_fenovo')
                            ->get();

            return Datatables::of($productos)

                ->addColumn('stock', function ($producto) {
                    return Product::find($producto->id)->stockReal(null, 1);
                })
                ->addColumn('costo', function ($producto) {
                    return '$' . $producto->costfenovo;
                })
                ->addColumn('proveedor', function ($producto) {
                    return $producto->proveedor;
                })
                ->addColumn('categoria', function ($producto) {
                    return $producto->categoria;
                })
                ->addColumn('ajuste', function ($producto) {
                    return '<a href="' . route('getData.stock.detail', ['id' => $producto->id]) . '"> <i class="fa fa-wrench" aria-hidden="true"></i> </a>';
                })
                ->addColumn('historial', function ($producto) {
                    return '<a href="' . route('product.historial', ['id' => $producto->id]) . '"> <i class="fa fa-list" aria-hidden="true"></i> </a>';
                })
                ->addColumn('editar', function ($producto) {
                    $ruta = route('product.nc.edit', ['id' => $producto->id]);
                    return '<a title="Editar" href="' . $ruta . '"><i class="fa fa-edit"></i></a>';
                })
                ->addColumn('borrar', function ($producto) {
                    $ruta = 'destroy(' . $producto->id . ",'" . route('product.destroy') . "')";
                    return '<a title="Delete" href="javascript:void(0)" onclick="' . $ruta . '"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['stock', 'costo', 'categoria', 'ajuste', 'historial', 'borrar', 'editar','proveedor'])
                ->make(true);
        }

        return view('admin.productsNoCongelados.list');
    }

    public function edit(Request $request){
        try {
            $fecha_actualizacion_label  = '';
            $fecha_actualizacion        = null;
            $fecha_actualizacion_activa = 0;
            $fecha_oferta               = null;
            $product                    = $this->productRepository->getByIdWith($request->id);

            if ($product) {
                $ofertas           = null;
                $oferta            = null;
                $alicuotas         = $this->alicuotaTypeRepository->get('value', 'DESC');
                $senasaDefinitions = $this->senasaDefinitionRepository->get('product_name', 'ASC');
                $categories        = $this->productCategoryRepository->getActives('name', 'ASC');
                $descuentos        = $this->productDescuentoRepository->getActives('descripcion', 'ASC');
                $proveedores       = $this->proveedorRepository->getActives('name', 'ASC');
                $unit_package      = explode('|', $product->unit_package);

                $productosProveedor = Product::where('proveedor_id', $product->proveedor_id)->paginate(1);
                return view(
                    'admin.productsNoCongelados.edit',
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
            return redirect()->route('products.nc.list')->with($notification);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(CalculatePrices $request){
        try {
            $data                 = $request->except('_token');
            $data['online_sale']  = isset($request->online_sale) ? 1 : 0;
            $data['iibb']         = isset($request->iibb) ? 1 : 0;
            $data['active']       = isset($request->active) ? 1 : 0;
            $product_id           = $data['product_id'];
            $data['unit_package'] = implode('|', $data['unit_package']);
            $producto_actualizado = $this->productRepository->fill($product_id, $data);

            $preciosCalculados = $this->calcularPrecios($request);

            if ($preciosCalculados['type'] == 'error') {
                return new JsonResponse(['type' => 'error', 'msj' => $preciosCalculados['msj']]);
            }

            $data = array_merge($data, $preciosCalculados);
            $producto = $this->productRepository->getByIdWith($product_id);
            $this->productPriceRepository->fill($producto->product_price->id, $data);

            return new JsonResponse(['type' => 'success', 'msj' => 'Producto modificado correctamente!']);
        } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error', 'msj' => $e->getMessage()]);
        }
    }
}
