<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Supplier;
use Image;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $supplier = Supplier::all();
    return response()->json($supplier);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validateData = $request->validate([
      'nama' => 'required|unique:suppliers|max:255',
      'email' => 'required',
      'no_telp' => 'required|unique:suppliers',

    ]);

    if ($request->foto) {
      $position = strpos($request->foto, ';');
      $sub = substr($request->foto, 0, $position);
      $ext = explode('/', $sub)[1];

      $nama = time() . "." . $ext;
      $img = Image::make($request->foto)->resize(240, 200);
      $upload_path = 'backend/supplier/';
      $image_url = $upload_path . $nama;
      $img->save($image_url);

      $supplier = new Supplier;
      $supplier->nama = $request->nama;
      $supplier->email = $request->email;
      $supplier->no_telp = $request->no_telp;
      $supplier->nama_toko = $request->nama_toko;
      $supplier->alamat = $request->alamat;
      $supplier->foto = '/' . $image_url;
      $supplier->save();
    } else {
      $supplier = new Supplier;
      $supplier->nama = $request->nama;
      $supplier->email = $request->email;
      $supplier->no_telp = $request->no_telp;
      $supplier->nama_toko = $request->nama_toko;
      $supplier->alamat = $request->alamat;

      $supplier->save();
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
    $supplier = DB::table('suppliers')->where('id', $id)->first();
    return response()->json($supplier);
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
    $data = array();
    $data['nama'] = $request->nama;
    $data['email'] = $request->email;
    $data['no_telp'] = $request->no_telp;
    $data['nama_toko'] = $request->nama_toko;
    $data['alamat'] = $request->alamat;

    $image = $request->newphoto;

    if ($image) {
      $position = strpos($image, ';');
      $sub = substr($image, 0, $position);
      $ext = explode('/', $sub)[1];

      $nama = time() . "." . $ext;
      $img = Image::make($image)->resize(240, 200);
      $upload_path = 'backend/supplier/';
      $image_url = $upload_path . $nama;
      $success = $img->save($image_url);

      if ($success) {
        $data['foto'] = '/' . $image_url;
        $img = DB::table('suppliers')->where('id', $id)->first();
        $image_path = $img->foto;
        $done = unlink(public_path($image_path));
        $user  = DB::table('suppliers')->where('id', $id)->update($data);
      }
    } else {
      $oldphoto = $request->foto;
      $data['foto'] = '/' . $oldphoto;
      $user = DB::table('suppliers')->where('id', $id)->update($data);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $supplier = DB::table('suppliers')->where('id', $id)->first();
    $foto = $supplier->foto;
    if ($foto) {
      unlink(public_path($foto));
      DB::table('suppliers')->where('id', $id)->delete();
    } else {
      DB::table('suppliers')->where('id', $id)->delete();
    }
  }
}