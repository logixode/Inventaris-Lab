<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use Image;
use DB;
use File;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoryController extends Controller
{

  public function makeDir($path)
  {
    if (!File::isDirectory(public_path($path)))
      File::makeDirectory(public_path($path), 0777, true, true);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $category = Category::all();

    foreach ($category as $key => $val) {
      $val['data_relation'] = $val->dataRelation;
    }
    return response()->json($category);
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
      'nama_kategori' => 'required|unique:categories|max:255',
      'id_kategori_inti' => 'required',
      'keterangan' => 'required|max:255',
    ]);

    $category = new Category;
    $category->nama_kategori = $request->nama_kategori;
    $category->id_kategori_inti = $request->id_kategori_inti;
    $category->keterangan = $request->keterangan;

    if ($request->gambar) {
      $position = strpos($request->gambar, ';');
      $sub = substr($request->gambar, 0, $position);
      $ext = explode('/', $sub)[1];

      $namaFile = time() . "." . $ext;
      $img = Image::make($request->gambar)->resize(240, 200);
      $uploadPath = 'backend/kategori/';
      $imageURL = $uploadPath . $namaFile;

      $this->makeDir($uploadPath);
      $img->save($imageURL);

      $category->gambar = '/' . $imageURL;
    }
    $category->save();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $category = DB::table('categories')->where('id', $id)->first();
    return response()->json($category);
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
    $data['nama_kategori'] =  $request->nama_kategori;
    $data['id_kategori_inti'] =  $request->id_kategori_inti;
    $data['keterangan'] =  $request->keterangan;

    $newPhoto = $request->new_photo;
    $gambar = $request->gambar;
    if ($newPhoto) {
      $position = strpos($gambar, ';');
      $sub = substr($gambar, 0, $position);
      $ext = explode('/', $sub)[1];

      $namaFile = time() . "." . $ext;
      $img = Image::make($gambar)->resize(240, 200);
      $uploadPath = 'backend/kategori/';
      $imageURL = $uploadPath . $namaFile;

      $this->makeDir($uploadPath);
      $success = $img->save($imageURL);

      if ($success) {
        $data['gambar'] = '/' . $imageURL;
        $img = DB::table('categories')->where('id', $id)->first();
        $imagePath = $img->gambar;

        try {
          unlink(public_path($imagePath));
        } catch (\Throwable $th) {
        }
      }
    }
    DB::table('categories')->where('id', $id)->update($data);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $category = DB::table('categories')->where('id', $id)->first();
    $gambar = $category->gambar;

    try {
      if ($gambar)
        unlink(public_path($gambar));
    } catch (\Throwable $th) {
    }
    DB::table('categories')->where('id', $id)->delete();
  }
}