<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{   
    public function index()
    {
        $publishers = Publisher::all();

        return response()->json([
            'code'       => 200,
            'status'     => 'success',
            'publishers' => $publishers
        ]);
    }

    public function show($id)
    {
        $publisher = Publisher::find($id);

        if (is_object($publisher)) {
            $data = [
                'code'       => 200,
                'status'     => 'success',
                'publisher'  => $publisher
            ];
        } else {
            $data = [
                'code'       => 404,
                'status'     => 'error',
                'message' => "La editorial no existe"
            ];
        }

        return response()->json($data, $data['code']);
    }


    // Guardar editorial(ADMIN)
    public function store(Request $request)
    {
        // Comprobar si el usuario es administrador
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $isAdmin = $jwtAuth->checkAdmin($token);

        if ($isAdmin) {
            // Recoger los datos por POST
            $json = $request->input('json', null);
            $params_array = json_decode($json, true);

            if ($params_array) {
                // Validar los datos
                $validate = Validator::make($params_array, [
                    'name'      => 'required|alpha'
                ]);

                // Guardar la categoría 
                if ($validate->fails()) {
                    $data = [
                        'code'       => 400,
                        'status'     => 'error',
                        'message'    => 'No se ha guardado la editorial.'
                    ];
                } else {
                    $publisher = new Publisher();
                    $publisher->name = $params_array['name'];
                    $publisher->save();

                    $data = [
                        'code'       => 200,
                        'status'     => 'success',
                        'publisher'   => $publisher
                    ];
                }
            } else {
                $data = [
                    'code'       => 400,
                    'status'     => 'error',
                    'message'    => 'No has enviado ninguna editorial.'
                ];
            }
        } else {
            // Si no es administrador, devolver un mensaje de error
            $data = [
                'code'      => 403,
                'status'    => 'error',
                'message'   => 'Acceso denegado. No tienes permisos para realizar esta acción.'
            ];
        }

        // Devolver el resultado
        return response()->json($data, $data['code']);
    }

    // Actualizar categoría (ADMIN)
    public function update($id, Request $request)
    {
        // Comprobar si el usuario es administrador
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $isAdmin = $jwtAuth->checkAdmin($token);

        if ($isAdmin) {
            // Recoger datos por PUT
            $json = $request->input('json', null);
            $params_array = json_decode($json, true);

            if (!empty($params_array)) {
                // Validar los datos
                $validate = Validator::make($params_array, [
                    'name'      => 'required|alpha'
                ]);

                // Quitar lo que no quiero actualizar
                unset($params_array['id']);
                unset($params_array['created_at']);

                // Actualizar la categoría
                $publisher = Publisher::where('id', $id)->update($params_array);

                $data = [
                    'code'       => 200,
                    'status'     => 'success',
                    'publisher'   => $params_array
                ];
            } else {
                $data = [
                    'code'       => 400,
                    'status'     => 'error',
                    'message'    => 'No has enviado ninguna editorial.'
                ];
            }
        } else {
            // Si no es administrador, devolver un mensaje de error
            $data = [
                'code'      => 403,
                'status'    => 'error',
                'message'   => 'Acceso denegado. No tienes permisos para realizar esta acción.'
            ];
        }


        // Devolver los datos
        return response()->json($data, $data['code']);
    }

    // Eliminar editorial (ADMIN)
    public function destroy($id, Request $request)
    {
        // Comprobar si el usuario es administrador
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $isAdmin = $jwtAuth->checkAdmin($token);

        if ($isAdmin) {
            $publisher = Publisher::find($id);

            if (!empty($publisher)) {
                $publisher->delete();

                $data = [
                    'code'       => 200,
                    'status'     => 'succes',
                    'message'    => 'Se ha eliminado la editorial.',
                    'publisher'   => $publisher
                ];
            } else {
                $data = [
                    'code'       => 404,
                    'status'     => 'error',
                    'message'    => 'No se ha encontrado la editorial.'
                ];
            }
        } else {
            // Si no es administrador, devolver un mensaje de error
            $data = [
                'code'      => 403,
                'status'    => 'error',
                'message'   => 'Acceso denegado. No tienes permisos para realizar esta acción.'
            ];
        }

        return response()->json($data, $data['code']);
    }
}
