<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'code'       => 200,
            'status'     => 'success',
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (is_object($category)) {
            $data = [
                'code'       => 200,
                'status'     => 'success',
                'category' => $category
            ];
        } else {
            $data = [
                'code'       => 404,
                'status'     => 'error',
                'message' => "La categoria no existe"
            ];
        }

        return response()->json($data, $data['code']);
    }


    // Guardar categoría (ADMIN)
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
                        'message'    => 'No se ha guardado la categoria.'
                    ];
                } else {
                    $category = new Category();
                    $category->name = $params_array['name'];
                    $category->save();

                    $data = [
                        'code'       => 200,
                        'status'     => 'success',
                        'category'   => $category
                    ];
                }
            } else {
                $data = [
                    'code'       => 400,
                    'status'     => 'error',
                    'message'    => 'No has enviado ninguna categoría.'
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
                $category = Category::where('id', $id)->update($params_array);

                $data = [
                    'code'       => 200,
                    'status'     => 'success',
                    'category'   => $params_array
                ];
            } else {
                $data = [
                    'code'       => 400,
                    'status'     => 'error',
                    'message'    => 'No has enviado ninguna categoría.'
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

    // Eliminar categoría (ADMIN)
    public function destroy($id, Request $request)
    {
        // Comprobar si el usuario es administrador
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $isAdmin = $jwtAuth->checkAdmin($token);

        if ($isAdmin) {
            $category = Category::find($id);

            if (!empty($category)) {
                $category->delete();

                $data = [
                    'code'       => 200,
                    'status'     => 'succes',
                    'message'    => 'Se ha eliminado la categoría.',
                    'category'   => $category
                ];
            } else {
                $data = [
                    'code'       => 404,
                    'status'     => 'error',
                    'message'    => 'No se ha encontrado la categoría.'
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
