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

        $perPage = 2;
        $search = $request->input('search');

        $query = Post::query();

        if($search){
            $query->where('titre', 'LIKE', "%{$search}%");
        }

        $total = $query->count();
        $posts = $query->paginate($perPage);

        try{

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Les posts ont été récupérés',
                'items' => $total,
                'data'=> $posts
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
                'status_code' => 200,
                'status_message' => 'Le post a été ajouté',
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
                    'status_code' => 422,
                    'status_message' => "Vous n'etes pas autorisé à modifier ce post",
                ]);
            }


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été modifié',
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
                    'status_code' => 422,
                    'status_message' => "Vous n'etes pas autorisé à supprimer ce post",
                ]);
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été supprimé',
                'data'=> $post
            ]);


        } catch(Exception $e){

            return response()->json($e);

        }

    }
}
