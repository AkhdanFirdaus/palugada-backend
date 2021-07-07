<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\WebinarDetailResource;
use App\Http\Resources\WebinarResource;
use App\Models\Favorite;
use App\Models\Narasumber;
use App\Models\PendaftarWebinar;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebinarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webinars = Webinar::select(
            'webinars.id as webinar_id',
            'webinars.*',
            'users.*'
        )
            ->join('users', 'users.id', '=', 'webinars.penyelenggara_id')
            ->orderBy('webinars.created_at', 'DESC')
            ->get();
        return WebinarResource::collection($webinars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $webinar = new Webinar();
            $webinar->nama = $request->nama;
            $webinar->deskripsi = $request->deskripsi;
            $webinar->kuota = $request->kuota;
            $webinar->tanggal = $request->tanggal;
            $webinar->jam_mulai = $request->jam_mulai;
            $webinar->jam_selesai = $request->jam_selesai;
            $webinar->penyelenggara_id = $request->penyelenggara_id;
            $webinar->link = $request->link;
            $webinar->save();

            foreach ($request->narasumber as $value) {
                $user = new User();
                $user->name = $value['name'];
                $user->email = $value['email'];
                $user->password = Hash::make('password');
                $user->nomor_telp = $value['nomor_telp'];
                $user->asal = $value['asal'];
                $user->role = 2;
                $user->save();

                $narasumber = new Narasumber();
                $narasumber->user_id = $user->id;
                $narasumber->webinar_id = $webinar->id;
                $narasumber->save();
            }
            DB::commit();
            return response()->json([
                'message' => 'Webinar dibuat',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat webinar',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $webinar = Webinar::select(
            'webinars.id as webinar_id',
            'webinars.*',
            'users.*'
        )
            ->join('users', 'users.id', '=', 'webinars.penyelenggara_id')
            ->find($id);

        $pendaftar = PendaftarWebinar::join('users', 'users.id', 'pendaftar_webinars.user_id')
            ->where('pendaftar_webinars.webinar_id', $id)
            ->get();

        $narasumber = Narasumber::join('users', 'users.id', 'narasumbers.user_id')
            ->where('narasumbers.webinar_id', $id)
            ->get();

        $data = [
            'webinar' => $webinar,
            'pendaftar' => $pendaftar,
            'narasumber' => $narasumber
        ];

        return new WebinarDetailResource($data);
    }

    public function countWebinar()
    {
        $count = Webinar::count();
        return response()->json([
            'count' => $count
        ]);
    }

    public function countPendaftar()
    {
        $count = PendaftarWebinar::count();
        return response()->json([
            'count' => $count
        ]);
    }

    public function countMyWebinar($userId)
    {
        $count = Webinar::where('penyelenggara_id', $userId)->count();
        dd($count);
    }

    public function myWebinar($userId)
    {
        $webinars = Webinar::select(
            'webinars.id AS webinar_id',
            'webinars.*',
            'users.*'
        )
            ->join('users', 'users.id', '=', 'webinars.penyelenggara_id')
            ->where('webinars.penyelenggara_id', $userId)
            ->get();
        return WebinarResource::collection($webinars);
    }

    public function joinedWebinar($userId)
    {
        $data = PendaftarWebinar::select(
            'webinars.id AS webinar_id',
            'webinars.*',
            'users.*'
        )
            ->join('webinars', 'webinars.id', '=', 'pendaftar_webinars.webinar_id')
            ->join('users', 'users.id', '=', 'webinars.penyelenggara_id')
            ->where('pendaftar_webinars.user_id', $userId)
            ->orderBy('webinars.tanggal', 'DESC')
            ->get();
        return WebinarResource::collection($data);
    }

    public function daftar(Request $request)
    {
        $daftar = new PendaftarWebinar();
        $daftar->webinar_id = $request->webinar_id;
        $daftar->user_id = $request->user_id;
        if ($daftar->save()) {
            return response()->json([
                'message' => 'berhasil daftar',
            ]);
        } else {
            return response()->json([
                'message' => 'gagal daftar',
            ]);
        }
    }

    public function webinarPenyelenggara($userId)
    {
        $webinars = Webinar::select(
            'webinars.id as webinar_id',
            'webinars.*',
            'users.*'
        )
            ->join('users', 'users.id', '=', 'webinars.penyelenggara_id')
            ->orderBy('webinars.created_at', 'DESC')
            ->where('webinars.penyelenggara_id', $userId)
            ->get();
        return WebinarResource::collection($webinars);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
