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

        $query = Post::query();
        $perPage = 2;
        $page = $request->input('page', 1);
        $search = $request->input('search');

        if($search){
            $query->whereRaw("titre LIKE '%". $search . "%'");
        }

        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        try{

            return response()->json([
                'statuts_code' => 200,
                'statuts_message' => 'Les posts ont été récupérés',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
                // 'data'=> Post::all()
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
                'statuts_code' => 200,
                'statuts_message' => 'Le post a été ajouté',
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
                    'statuts_code' => 422,
                    'statuts_message' => "Vous n'etes pas autorisé à modifier ce post",
                ]);
            }


            return response()->json([
                'statuts_code' => 200,
                'statuts_message' => 'Le post a été modifié',
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
                    'statuts_code' => 422,
                    'statuts_message' => "Vous n'etes pas autorisé à supprimer ce post",
                ]);
            }

            return response()->json([
                'statuts_code' => 200,
                'statuts_message' => 'Le post a été supprimé',
                'data'=> $post
            ]);


        } catch(Exception $e){

            return response()->json($e);

        }

    }
}
