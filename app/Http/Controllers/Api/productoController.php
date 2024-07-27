<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productoController extends Controller
{
    public function index(){
        $productos = Producto::all();

        if($productos->isEmpty()){
            $data = [
                'message' => 'No se encontraron productos',
                'status'=> 404,
            ];
            return response() ->json($data, 404);
        }
        return response() ->json($productos, 200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'stock'=> 'required',
            'precio'=> 'required',
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

        $producto = Producto::create([
            'name'=> $request->name,
            'stock'=> $request->stock,
            'precio'=> $request->precio,
            'total' => $request->total,
        ]);

        if(!$producto){
            $data = [
                'message'=> 'Error al crear el producto',
                'status'=> 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            'producto' => $producto,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

    public function show($id){
        $producto = Producto::find($id);

        if(!$producto){
            $data = [
                'message' => 'Producto no encontrado',
                'status'=> 404,
            ];
            return response()->json($data,404);
        }

        $data = [
            'producto' => $producto,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){

    $producto = Producto::find($id);

    if(!$producto){
        $data = [
            'message'=> 'Producto no encontrado',
            'status'=> 404,
        ];
        return response()->json($data, 404);
    }

    $producto->delete();
    $data = [
        'message' => 'Producto eliminado',
        'status'=> 200,
    ];

    return response()->json($data, 200);

    } 

    public function update(Request $request, $id){

        $producto = Producto::find($id);

        if(!$producto){
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'stock'=> 'required',
            'precio'=> 'required',
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

        $producto->name = $request->name;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;
        $producto->total = $request->total;
        $producto->save();
        $data = [
            'message' => 'Producto Actualizado',
            'producto' => $producto,
            'status'=> 200,
        ];

        if($request->has('name')){
            $producto->name = $request->name;
        }
        if($request->has('stock')){
            $producto->stock = $request->stock;
        }
        if($request->has('precio')){
            $producto->precio = $request->precio;
        }
        if($request->has('total')){
            $producto->total = $request->total;
        }

    }

}