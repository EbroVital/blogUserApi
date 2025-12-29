<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index(Request $request){

<<<<<<< HEAD
        $perPage = 2;
        $search = $request->input('search');

        $query = Post::query();

        if($search){
            $query->where('titre', 'LIKE', "%{$search}%");
        }

        $total = $query->count();
        $posts = $query->paginate($perPage);
=======
        $query = Post::query();
        $perPage = 2;
        $page = $request->input('page', 1);
        $search = $request->input('search');

        if($search){
            $query->whereRaw("titre LIKE '%". $search . "%'");
        }

        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();
>>>>>>> c3472895064950c8c6bf3814b4e244e42947fed3

        try{

            return response()->json([
<<<<<<< HEAD
                'status_code' => 200,
                'status_message' => 'Les posts ont été récupérés',
                'items' => $total,
                'data'=> $posts
=======
                'statuts_code' => 200,
                'statuts_message' => 'Les posts ont été récupérés',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
                // 'data'=> Post::all()
>>>>>>> c3472895064950c8c6bf3814b4e244e42947fed3
            ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    public function store(CreatePostRequest $request){

        try{

            $post = new Post();
            $post->titre = $request->titre;
            $post->user_id = auth()->user()->id;
            $post->description = $request->description;
            $post->save();

            return response()->json([
<<<<<<< HEAD
                'status_code' => 200,
                'status_message' => 'Le post a été ajouté',
=======
                'statuts_code' => 200,
                'statuts_message' => 'Le post a été ajouté',
>>>>>>> c3472895064950c8c6bf3814b4e244e42947fed3
                'data'=> $post
            ]);

        }
        catch(Exception $e){
            return response()->json($e);
        }

    }

    public function update(EditPostRequest $request, Post $post){

        try{

            $post->titre = $request->titre;
            $post->description = $request->description;

            if($post->user_id == auth()->user()->id){
                $post->save();
            } else {
                return response()->json([
<<<<<<< HEAD
                    'status_code' => 422,
                    'status_message' => "Vous n'etes pas autorisé à modifier ce post",
=======
                    'statuts_code' => 422,
                    'statuts_message' => "Vous n'etes pas autorisé à modifier ce post",
>>>>>>> c3472895064950c8c6bf3814b4e244e42947fed3
                ]);
            }


            return response()->json([
<<<<<<< HEAD
                'status_code' => 200,
                'status_message' => 'Le post a été modifié',
=======
                'statuts_code' => 200,
                'statuts_message' => 'Le post a été modifié',
>>>>>>> c3472895064950c8c6bf3814b4e244e42947fed3
                'data'=> $post
            ]);

        }
        catch(Exception $e){
            return response()->json($e);
        }
    }

    public function delete(Post $post){

        // dd($post);

        try{

             if($post->user_id == auth()->user()->id){
                $post->delete();
            } else {
                return response()->json([
<<<<<<< HEAD
                    'status_code' => 422,
                    'status_message' => "Vous n'etes pas autorisé à supprimer ce post",
=======
                    'statuts_code' => 422,
                    'statuts_message' => "Vous n'etes pas autorisé à supprimer ce post",
>>>>>>> c3472895064950c8c6bf3814b4e244e42947fed3
                ]);
            }

            return response()->json([
<<<<<<< HEAD
                'status_code' => 200,
                'status_message' => 'Le post a été supprimé',
=======
                'statuts_code' => 200,
                'statuts_message' => 'Le post a été supprimé',
>>>>>>> c3472895064950c8c6bf3814b4e244e42947fed3
                'data'=> $post
            ]);


        } catch(Exception $e){

            return response()->json($e);

        }

    }
}
