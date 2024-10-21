<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Helpers\JwtAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();

        return response()->json([
            'code'       => 200,
            'status'     => 'success',
            'authors' => $authors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Comprobar si el usuario es administrador
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $isAdmin = $jwtAuth->checkAdmin($token);

        if ($isAdmin) {
            // Recoger los datos del usuario
            $json =  $request->input('json', null);
            $params_array = json_decode($json, true);

            if (!empty($params_array)) {
                // Validar
                $validate = Validator::make($params_array, [
                    'name' => 'required|string',
                ]);
                if ($validate->fails()) {
                    // Fallo en la validación
                    $data = [
                        'code'      => 400,
                        'status'    => 'error',
                        'message'   =>  'Error en los datos del autor.'
                    ];
                } else {
                    // Guardar autor en la base de datos

                    $author = new Author();

                    $author->name = $params_array['name'];

                    $author->save();

                    $data = [
                        'code'      => 200,
                        'status'    => 'success',
                        'message'   =>  'Autor creado exitosamente.',
                        'author'    => $author
                    ];
                }
            } else {
                // Envío vacío

                $data = [
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No has enviando ningún autor.',
                    'isAdmin'   => $isAdmin
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Recoger el ID de autor
        $author = Author::find($id);

        if (is_object($author)) {
            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'author'    => $author
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message'       => 'El autor no existe.'
            );
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Recoger los datos por PUT
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            // Validar los datos
            $validate = Validator::make($params_array, [
                'name' => 'required|alpha',
            ]);

            // Quitar los datos que no necesitamos
            unset($params_array['id']);
            unset($params_array['created_at']);

            // Actualizar en la base de datos
            $author = Author::where('id', $id)->update($params_array);

            $data = [
                'code'       => 200,
                'status'     => 'success',
                'author'   => $params_array
            ];
        } else {
            $data = [
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Error no se ha enviado ningún autor.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        // Sacar autor de la BD
        $author = Author::find($id);

        if (!empty($author)) {
            $author->delete();

            $data = [
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Se ha eliminado el autor.',
                'author'    => $author
            ];
        } else {
            $data = [
                'code'      => 404,
                'status'    => 'error',
                'message'   => 'No se encontró el autor.'
            ];
        }

        return response()->json($data, $data['code']);
    }
}
