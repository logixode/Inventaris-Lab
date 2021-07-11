<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Employee;
use Image;
use DB;

class EmployeeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $employee = Employee::all();
    return response()->json($employee);
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
      'nama' => 'required|unique:employees|max:255',
      'email' => 'required',
      'no_telp' => 'required|unique:employees',

    ]);

    if ($request->foto) {
      $position = strpos($request->foto, ';');
      $sub = substr($request->foto, 0, $position);
      $ext = explode('/', $sub)[1];

      $nama_file = time() . "." . $ext;
      $img = Image::make($request->foto)->resize(240, 200);
      $upload_path = 'backend/employee/';
      $image_url = $upload_path . $nama_file;
      $img->save($image_url);

      $employee = new Employee;
      $employee->nama = $request->nama;
      $employee->email = $request->email;
      $employee->no_telp = $request->no_telp;
      $employee->sallery = $request->sallery;
      $employee->address = $request->address;
      $employee->nid = $request->nid;
      $employee->joining_date = $request->joining_date;
      $employee->foto = '/' . $image_url;
      $employee->save();
    } else {
      $employee = new Employee;
      $employee->nama = $request->nama;
      $employee->email = $request->email;
      $employee->no_telp = $request->no_telp;
      $employee->sallery = $request->sallery;
      $employee->address = $request->address;
      $employee->nid = $request->nid;
      $employee->joining_date = $request->joining_date;

      $employee->save();
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
    $employee = DB::table('employees')->where('id', $id)->first();
    return response()->json($employee);
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
    $data['sallery'] = $request->sallery;
    $data['address'] = $request->address;
    $data['nid'] = $request->nid;
    $data['joining_date'] = $request->joining_date;
    $image = $request->newphoto;

    if ($image) {
      $position = strpos($image, ';');
      $sub = substr($image, 0, $position);
      $ext = explode('/', $sub)[1];

      $nama_file = time() . "." . $ext;
      $img = Image::make($image)->resize(240, 200);
      $upload_path = 'backend/employee/';
      $image_url = $upload_path . $nama_file;
      $success = $img->save($image_url);

      if ($success) {
        $data['foto'] = '/' . $image_url;
        $img = DB::table('employees')->where('id', $id)->first();
        $image_path = $img->foto;
        $done =
          unlink(public_path($image_path));
        $user  = DB::table('employees')->where('id', $id)->update($data);
      }
    } else {
      $oldphoto = $request->foto;
      $data['foto'] = '/' . $oldphoto;
      $user = DB::table('employees')->where('id', $id)->update($data);
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
    $employee = DB::table('employees')->where('id', $id)->first();
    $foto = $employee->foto;
    if ($foto) {
      unlink(public_path($foto));
      DB::table('employees')->where('id', $id)->delete();
    } else {
      DB::table('employees')->where('id', $id)->delete();
    }
  }
}