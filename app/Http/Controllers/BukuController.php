<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Response\BaseResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function listBuku(){
        try {
            $buku = Buku::query()->get();
            if($buku){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Get Data Book Successfully',
                    'data' => $buku
                ],200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Data is Not Found'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi Kesalahan',
                'kesalahan' => throw $th
            ]);
        }
    }

    public function addBuku(Request $request){
        $rules = [
            'judul' => 'required',
            'penulis' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png|max:10024',
            'deskripsi' => 'required',
        ];

        $messege = [
            'judul.required' => 'judul Harus Diisi',
            'penulis.required' => 'Penulis Harus Diisi',
            'gambar.required' => 'gambar Harus Diisi',
            'gambar.mimes' => 'Extension gambar harus jpg,jpeg,png',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
            'deskripsi.required' => 'Deskripsi Harus Diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messege);

        if($validator->fails()){
            $errors = $validator->errors()->getMessages();
            $row_error = [];
            foreach ($errors as $value) {
                array_push($row_error,implode(",",$value));
            }
            return response()->json([
                'message' => implode(',',$row_error)
            ], 400);
        }

        $data = $validator->validate();

        $image_path = null;
        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $image_path = $file->store('books', 'public');
        }
        $data['gambar'] = $image_path;

        try {
            $buku_added = Buku::create($data);
            if($buku_added){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Add Book Data Successfully',
                    'data' => $buku_added
                ],201);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Add Book Data is failed'
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi Kesalahan',
                'kesalahan' => throw $th
            ]);
        }
    }

    public function getBukuById($id){
        if($id){
            $data = Buku::query()->where('id',$id)->first();
            if($data){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Get Successfully',
                    'data' => $data
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Data Get Error'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'id not found'
            ]);
        }

    }

    public function updateBuku(Request $request, $id){
        if(!$id){
            return response()->json([
                'status' => 'error',
                'message' => 'Id is not found'
            ], 404);
        }

        $rules = [
            'judul' => 'required',
            'penulis' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png|max:10024',
            'deskripsi' => 'required',
        ];

        $messege = [
            'judul.required' => 'judul Harus Diisi',
            'penulis.required' => 'Penulis Harus Diisi',
            'gambar.required' => 'gambar Harus Diisi',
            'gambar.mimes' => 'Extension gambar harus jpg,jpeg,png',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
            'deskripsi.required' => 'Deskripsi Harus Diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messege);

        if($validator->fails()){
            $errors = $validator->errors()->getMessages();
            $row_error = [];
            foreach ($errors as $value) {
                array_push($row_error,implode(",",$value));
            }
            return response()->json([
                'message' => implode(',',$row_error)
            ], 400);
        }

        $data = $validator->validate();

        $lates_data = Buku::query()->where('id', $id)->first();
        Storage::delete('public/' . $lates_data->gambar);
        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $image_path = $file->store('books', 'public');
            $data['gambar'] = $image_path;
        }

        try {
            $is_updated = Buku::query()->where('id', $id)->update($data);
            if($is_updated){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Update Book Data Successfully',
                ],201);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Update Book Data is failed'
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi Kesalahan',
                'kesalahan' => throw $th
            ]);
        }
    }

    public function deleteBuku($id){
        if(!$id){
            return response()->json([
                'status' => 'error',
                'message' => 'Id is Required'
            ], 404);
        }

        $lates_data = Buku::query()->where('id', $id)->first();
        Storage::delete('public/' . $lates_data->gambar);

        try {
            $is_deleted = Buku::query()->where('id', $id)->delete();
            if($is_deleted){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Delete Book Data Successfully',
                ],200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Update Book Data is failed'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi Kesalahan',
                'kesalahan' => throw $th
            ]);
        }
    }
}
