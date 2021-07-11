<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\KategoriInti;
use Illuminate\Http\Request;

class KategoriIntiController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = KategoriInti::all();
    return response()->json($data);
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
   * @param  \App\KategoriInti  $kategoriInti
   * @return \Illuminate\Http\Response
   */
  public function show(KategoriInti $kategoriInti)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\KategoriInti  $kategoriInti
   * @return \Illuminate\Http\Response
   */
  public function edit(KategoriInti $kategoriInti)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\KategoriInti  $kategoriInti
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, KategoriInti $kategoriInti)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\KategoriInti  $kategoriInti
   * @return \Illuminate\Http\Response
   */
  public function destroy(KategoriInti $kategoriInti)
  {
    //
  }
}