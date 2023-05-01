<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbingLapangan;
use Illuminate\Http\Request;

class DosenPembimbingLapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen_pembimbing_lapangan = DosenPembimbingLapangan::get();
        return view('Admin.pages.dosen-pembimbing-lapangan.index',compact('dosen_pembimbing_lapangan'));
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
     * @param  \App\Models\DosenPembimbingLapangan  $dosenPembimbingLapangan
     * @return \Illuminate\Http\Response
     */
    public function show(DosenPembimbingLapangan $dosenPembimbingLapangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DosenPembimbingLapangan  $dosenPembimbingLapangan
     * @return \Illuminate\Http\Response
     */
    public function edit(DosenPembimbingLapangan $dosenPembimbingLapangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DosenPembimbingLapangan  $dosenPembimbingLapangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DosenPembimbingLapangan $dosenPembimbingLapangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DosenPembimbingLapangan  $dosenPembimbingLapangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(DosenPembimbingLapangan $dosenPembimbingLapangan)
    {
        //
    }
}
