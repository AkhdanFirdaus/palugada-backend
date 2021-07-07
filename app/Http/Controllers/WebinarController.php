<?php

namespace App\Http\Controllers;

use App\Http\Resources\WebinarDetailResource;
use App\Http\Resources\WebinarResource;
use App\Models\Narasumber;
use App\Models\PendaftarWebinar;
use App\Models\Webinar;
use Illuminate\Http\Request;

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
        //
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
