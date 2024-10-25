<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Helpers\JwtAuth;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'code'       => 200,
            'status'     => 'success',
            'categories' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // Guardar libro (ADMIN)
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
                    'name'              => 'required|alpha',
                    'author'            => 'required|alpha',
                    'publisher'         => 'required|alpha',
                    'category'          => 'required|alpha',
                    'year_published'    => 'required|alpha',
                    'description'       => 'required|alpha',
                    'image'             => 'required|alpha',
                    'isbn'              => 'required|alpha',
                    'google_books_id'   => 'integer'
                ]);

                // Guardar la el libro
                if ($validate->fails()) {
                    $data = [
                        'code'       => 400,
                        'status'     => 'error',
                        'message'    => 'No se ha guardado el libro.'
                    ];
                } else {
                    $params_array['isbn'] = str_replace('-', '', $params_array['isbn']);

                    // Buscar si el libro ya existe por nombre
                    $existingBook = Book::where('name', $params_array['name'])
                                        ->orWhere('isbn', $params_array['isbn'])
                                        ->first();

                    if($existingBook){
                        // El libro está guardado
                        $data = [
                            'code'      => '400',
                            'status'    => 'error',
                            'message'   => 'El libro ya existe.'
                        ];

                    }else{
                        // El libro no está guardado
                        $author = Author::where('name', $params_array['author'])
                                        ->first();
                        
                        if ($author){
                            $params_array['author_id'] = $author['id'];
                        }else{
                            // Guardar el nuevo autor

                            $author = new Author();
                            $author->name = $params_array['author'];
                            $author->save();
                        }
                        
                        $publisher = Publisher::where('name', $params_array['publisher'])  
                                                ->first();           
                    }

                    $book = new Book();
                    $book->name = $params_array['name'];
                    $book->save();

                    $data = [
                        'code'       => 200,
                        'status'     => 'success',
                        'category'   => $book
                    ];
                }
            } else {
                $data = [
                    'code'       => 400,
                    'status'     => 'error',
                    'message'    => 'No has enviado ningun libro.'
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);

        if (is_object($book)) {
            $data = [
                'code'       => 200,
                'status'     => 'success',
                'category'   => $book
            ];
        } else {
            $data = [
                'code'       => 404,
                'status'     => 'error',
                'message' => "El libro no existe"
            ];
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
