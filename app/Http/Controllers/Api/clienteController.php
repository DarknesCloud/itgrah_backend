<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class clienteController extends Controller
{
    public function index(){
        $clientes = Cliente::all();

        if($clientes->isEmpty()){
            $data = [
                'message' => 'No se encontraron clientes',
                'status'=> 404,
            ];
            return response() ->json($data, 404);
        }
        return response() ->json($clientes, 200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'lastname'=> 'required',
            'rtn'=> 'required',
            'direccion'=> 'required',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion',
                'errors'=> $validator->errors(),
                'status' => 400,
            ];
            return response() ->json($data, 400);
        }

        $cliente = Cliente::create([
            'name'=> $request->name,
            'lastname'=> $request->lastname,
            'rtn'=> $request->rtn,
            'direccion' => $request->direccion,
        ]);

        if(!$cliente){
            $data = [
                'message'=> 'Error al crear el cliente',
                'status'=> 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            'cliente' => $cliente,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

    public function show($id){
        $cliente = Cliente::find($id);

        if(!$cliente){
            $data = [
                'message' => 'Cliente no encontrado',
                'status'=> 404,
            ];
            return response()->json($data,404);
        }

        $data = [
            'cliente' => $cliente,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){

    $cliente = Cliente::find($id);

    if(!$cliente){
        $data = [
            'message'=> 'Cliente no encontrado',
            'status'=> 404,
        ];
        return response()->json($data, 404);
    }

    $cliente->delete();
    $data = [
        'message' => 'Cliente eliminado',
        'status'=> 200,
    ];

    return response()->json($data, 200);

    } 

    public function update(Request $request, $id){

        $cliente = Cliente::find($id);

        if(!$cliente){
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'lastname'=> 'required',
            'rtn'=> 'required',
            'direccion'=> 'required',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $cliente->name = $request->name;
        $cliente->lastname = $request->lastname;
        $cliente->rtn = $request->rtn;
        $cliente->direccion = $request->direccion;
        $cliente->save();
        $data = [
            'message' => 'Cliente Actualizado',
            'cliente' => $cliente,
            'status'=> 200,
        ];

        if($request->has('name')){
            $cliente->name = $request->name;
        }
        if($request->has('lastname')){
            $cliente->lastname = $request->lastname;
        }
        if($request->has('rtn')){
            $cliente->rtn = $request->rtn;
        }
        if($request->has('direccion')){
            $cliente->direccion = $request->direccion;
        }

    }

}