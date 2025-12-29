<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route test inscription simple
Route::post('/test-register', function (Request $request) {
    try {
        \Illuminate\Support\Facades\Log::info('Test register reçu:', $request->all());

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        $token = $user->createToken('test')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
});


Route::get('/test', function () {
    return response()->json([
        'status' => 'API Laravel opérationnelle',
        'timestamp' => now()
    ]);
});

Route::middleware('api')->group(function (){
    // inscrire un nouvel utilisateur
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::middleware(['api', 'auth:sanctum'])->group( function (){
    Route::get('/user', function(Request $request){
        return $request->user();
    });

    Route::post('/logout', [UserController::class, 'logout']);

    // recuperer la liste des posts de l'utilisateur
    Route::get('posts', [PostController::class, 'index']);
    // Ajouter un post
    Route::post('posts/create', [PostController::class, 'store']);
    // editer un post
    Route::put('posts/edit/{post}', [PostController::class, 'update']);
    // supprimer un post
    Route::delete('posts/{post}', [PostController::class, 'delete']);

});



