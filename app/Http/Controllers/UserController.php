<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->firstOrFail();
            return new UserResource($user);
        } else {
            return response()->json([
                "message" => "Invalid Credentials"
            ]);
        }
    }

    public function loginWithId(Request $request)
    {
        $user = Auth::loginUsingId($request->user_id);
        if (isset($user)) {
            return new UserResource($user);
        } else {
            return response()->json([
                "message" => "User Not Found"
            ]);
        }
    }

    public function showUser($id)
    {
        $user = Auth::loginUsingId($id);
        if (isset($user)) {
            return new UserResource($user);
        } else {
            return response()->json([
                "message" => "User Not Found"
            ]);
        }
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'nomor_telp' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'asal' => 'required|string',
            'role' => 'required|integer'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Gagal Validasi'
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nomor_telp = $request->nomor_telp;
        $user->asal = $request->asal;
        $user->role = (int) $request->role;
        if ($user->save()) {
            return response()->json([
                'message' => 'Berhasil daftar',
                'user_id' => $user->id
            ], 200);
        } else {
            return response()->json([
                'message' => 'Gagal daftar'
            ], 500);
        }
    }

    public function listPenyelenggara()
    {
        $penyelenggara = User::select(
            'users.*',
            DB::raw('COUNT(webinars.id) AS count_webinar')
        )
            ->join('webinars', 'webinars.penyelenggara_id', 'users.id')
            ->orderBy('users.name', 'ASC')
            ->groupBy('webinars.penyelenggara_id')
            ->get();
        return UserResource::collection($penyelenggara);
    }

    public function penyelenggaraDetail($userId)
    {
        $penyelenggara = User::select(
            'users.*',
            DB::raw('COUNT(webinars.id) AS count_webinar')
        )
            ->join('webinars', 'webinars.penyelenggara_id', 'users.id')
            ->find($userId);
        // dd($penyelenggara);
        return new UserResource($penyelenggara);
    }

    public function listFavorite($userId)
    {
        $data = Favorite::select('users.*', DB::raw('COUNT(webinars.id) AS count_webinar'))
            ->join('webinars', 'webinars.penyelenggara_id', 'favorites.penyelenggara_id')
            ->join('users', 'users.id', '=', 'favorites.penyelenggara_id')
            ->where('favorites.user_id', $userId)
            ->orderBy('users.created_at', 'DESC')
            ->get();
        return UserResource::collection($data);
    }

    public function favorite(Request $request)
    {
        $favorite = new Favorite();
        $favorite->user_id = $request->user_id;
        $favorite->penyelenggara_id = $request->penyelenggara_id;
        if ($favorite->save()) {
            return response()->json([
                'message' => 'favorite',
            ]);
        } else {
            return response()->json([
                'message' => 'gagal favorite',
            ]);
        }
    }
}
