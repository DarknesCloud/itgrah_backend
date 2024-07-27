<?php

namespace App\Http\Controllers\Api;
use App\Models\Api\Factura;
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

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'cliente'=> 'required',
            'tipo_factura'=> 'required',
            'producto'=> 'required',
            'cantidad'=> 'required',
            'subtotal'=> 'required',
            'total'=> 'required',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion',
                'errors'=> $validator->errors(),
                'status' => 400,
            ];
            return response() ->json($data, 400);
        }

        $factura = Factura::create([
            'cliente'=> $request->cliente,
            'tipo_factura'=> $request->tipo_factura,
            'producto'=> $request->producto,
            'cantidad' => $request->cantidad,
            'subtotal'=> $request->subtotal,
            'total' => $request->total,
        ]);

        if(!$factura){
            $data = [
                'message'=> 'Error al crear la facutra',
                'status'=> 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            'factura' => $factura,
            'status' => 201
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