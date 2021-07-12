<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\KategoriInti;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'kategori_inti' => 'required|unique:kategori_intis|max:75',
    ]);
    $data = new KategoriInti([
      'kategori_inti' => $request->get('kategori_inti')
    ]);

    $data->save();
    return $data;
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
    $request->validate([
      'kategori_inti' => 'required|unique:kategori_intis|max:75',
    ]);
    $data = KategoriInti::where('id', '=', $request->get('id'))->firstOrFail();
    $data->kategori_inti = $request->get('kategori_inti');
    $data->save();

    return $request;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\KategoriInti  $kategoriInti
   * @return \Illuminate\Http\Response
   */
  public function destroy(KategoriInti $kategoriInti)
  {
    try {
      DB::table('kategori_intis')->where('id', $kategoriInti->id)->delete();
    } catch (\Exception  $exception) {
      return response()->json(['error' => 'Data tidak dapat dihapus karena sedang digunakan'], 500);

      // throw new HttpException(500, $exception->getMessage());
    }
    return $kategoriInti;
  }
}