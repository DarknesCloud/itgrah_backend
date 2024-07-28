<?php

namespace App\Http\Controllers\Api;
use App\Models\Api\Factura;
use App\Models\Api\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class facturaController extends Controller
{
    public function index(){
        $factura = Factura::all();

        if($factura->isEmpty()){
            $data = [
                'message' => 'No se encontraron facturas',
                'status'=> 404,
            ];
            return response() ->json($data, 404);
        }
        return response() ->json($factura, 200);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'cliente' => 'required',
        'tipo_factura' => 'required',
        'producto' => 'required',
        'cantidad' => 'required',
        'precio' => 'required',
        'subtotal' => 'required',
        'total' => 'required',
    ]);

    if ($validator->fails()) {
        $data = [
            'message' => 'Error en la validación',
            'errors' => $validator->errors(),
            'status' => 400,
        ];
        return response()->json($data, 400);
    }

    // Obtener el producto por nombre
    $producto = Producto::where('name', $request->producto)->first();

    if (!$producto) {
        $data = [
            'message' => 'Producto no encontrado',
            'status' => 404,
        ];
        return response()->json($data, 404);
    }

    // Verificar si hay suficiente stock
    if ($producto->stock < $request->cantidad) {
        $data = [
            'message' => 'Stock insuficiente',
            'status' => 400,
        ];
        return response()->json($data, 400);
    }

    // Crear la factura
    $factura = Factura::create([
        'cliente' => $request->cliente,
        'tipo_factura' => $request->tipo_factura,
        'producto' => $request->producto,
        'precio' => $request->precio,
        'cantidad' => $request->cantidad,
        'subtotal' => $request->subtotal,
        'total' => $request->total,
    ]);

    if (!$factura) {
        $data = [
            'message' => 'Error al crear la factura',
            'status' => 500,
        ];
        return response()->json($data, 500);
    }

    // Actualizar el stock del producto
    $producto->stock -= $request->cantidad;
    $producto->save();

    $data = [
        'factura' => $factura,
        'status' => 201,
    ];

    return response()->json($data, 201);
}


    public function show($id){
        $factura = Factura::find($id);

        if(!$factura){
            $data = [
                'message' => 'Factura no encontrado',
                'status'=> 404,
            ];
            return response()->json($data,404);
        }

        $data = [
            'factura' => $factura,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){

    $factura = Factura::find($id);

    if(!$factura){
        $data = [
            'message'=> 'Factura no encontrada',
            'status'=> 404,
        ];
        return response()->json($data, 404);
    }

    $factura->delete();
    $data = [
        'message' => 'Factura eliminada',
        'status'=> 200,
    ];

    return response()->json($data, 200);

    } 

    public function update(Request $request, $id){

        $factura = Factura::find($id);

        if(!$factura){
            $data = [
                'message' => 'Factura no encontrada',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'cliente'=> 'required',
            'tipo_factura'=> 'required',
            'producto'=> 'required',
            'precio' => 'required',
            'cantidad'=>'required',
            'subtotal'=>'required',
            'total'=> 'required',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $factura->cliente = $request->cliente;
        $factura->tipo_factura = $request->tipo_factura;
        $factura->producto = $request->producto;
        $factura->precio = $request->precio;
        $factura->cantidad = $request->cantidad;
        $factura->subtotal = $request->subtotal;
        $factura->total = $request->total;
        $factura->save();
        $data = [
            'message' => 'Factura Actualizada',
            'factura' => $factura,
            'status'=> 200,
        ];

        if($request->has('cliente')){
            $factura->cliente = $request->cliente;
        }
        if($request->has('tipo_factura')){
            $factura->tipo_factura = $request->tipo_factura;
        }
        if($request->has('producto')){
            $factura->producto = $request->producto;
        }
        if($request->has('precio')){
            $factura->precio = $request->precio;
        }
        if($request->has('cantidad')){
            $factura->cantidad = $request->cantidad;
        }
        if($request->has('subtotal')){
            $factura->subtotal = $request->subtotal;
        }
        if($request->has('total')){
            $factura->total = $request->total;
        }

    }

}