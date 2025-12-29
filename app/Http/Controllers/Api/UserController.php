<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterUser $request){

        try{

            Log::info('=== DÉBUT INSCRIPTION ===');
            Log::info('Données reçues:', $request->all());

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            Log::info('Utilisateur créé:', ['user_id' => $user->id]);

            Auth::login($user);

            // Créer un token pour l'API
            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('Utilisateur connecté et token créé');


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur enregistré avec succès',
                'user'=> $user,
                'token' => $token
            ]);

        } catch(Exception $e){
            // return response()->json($e);
            Log::error('Erreur inscription:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

             return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de l\'inscription: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }

    }

    // public function login(Request $request){

    //     try{

    //         Log::info('=== DÉBUT CONNEXION ===');
    //         Log::info('Email:', $request->email);
    //         $credentials = $request->only('email', 'password');

    //         if(auth()->attempt($credentials)){

    //             $user = auth()->user();
    //             $token = $user->createToken('auth_token')->plainTextToken;

    //             $request->session()->regenerate();

    //             Log::info('Connexion réussie:', ['user_id' => $user->id]);

    //             return response()->json([
    //                 'statuts_code' => 200,
    //                 'statuts_message' => 'Connexion réussie',
    //                 'user' => $user,
    //                 'token' => $token
    //             ]);
    //         }
    //         else {
    //             Log::warning('Échec de connexion pour:', $request->email);

    //             return response()->json([
    //                 'statuts_code' => 401,
    //                 'statuts_message' => 'Informations non valides !'
    //             ]);
    //         }

    //     } catch(Exception $e) {

    //         Log::error('Erreur connexion:', [
    //             'message' => $e->getMessage()
    //         ]);

    //         return response()->json([
    //             'statuts_code' => 500,
    //             'statuts_message' => 'Erreur serveur: ' . $e->getMessage()
    //         ], 500);

    //     }

    // }

    public function login(Request $request)
{
    try {
        Log::info('=== DÉBUT CONNEXION ===');
        Log::info('Email: ' . $request->email);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('Connexion réussie pour user_id: ' . $user->id);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Connexion réussie',
                'user' => $user,
                'token' => $token
            ]);
        } else {
            Log::warning('Échec de connexion pour: ' . $request->email);

            return response()->json([
                'status_code' => 401,
                'status_message' => 'Informations non valides !'
            ], 401); // Ajoutez le status HTTP
        }

    } catch (Exception $e) {
        Log::error('Erreur connexion: ' . $e->getMessage());

        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur serveur: ' . $e->getMessage()
        ], 500);
    }
}

     public function logout(Request $request)
    {

        try{

            // Si utilisation de tokens
            if ($request->user()) {
                $request->user()->currentAccessToken()->delete();
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'Déconnexion réussie']);

        } catch(Exception $e){

            return response()->json([
                'message' => 'Erreur lors de la déconnexion: ' . $e->getMessage()
            ], 500);

        }
    }
}
