<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kelas.index');
    }
    public function getall()
    {
        $kelas = Kelas::all();

        return response()->json([
            'status' => 200,
            'kelas' => $kelas
        ]);
    }

    public function getDetail($id)
    {
        $kelas = Kelas::with(['siswas', 'guru'])->find($id);

        if (!$kelas) {
            return response()->json([
                'status' => 404,
                'message' => 'Kelas tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => 200,
            'kelas' => $kelas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Kelas berhasil ditambahkan!',
            'kelas' => $kelas
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kelas = Kelas::find($id);
        if ($kelas) {
            return response()->json([
                'status' => 200,
                'kelas' => $kelas
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kelas not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:kelas,id',
            'nama_kelas' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $kelas = Kelas::find($request->id);
        if ($kelas) {
            $kelas->update($request->only(['nama_kelas']));
            return response()->json([
                'status' => 200,
                'message' => 'Kelas updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'kelas not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'status' => 404,
                'message' => 'Kelas tidak ditemukan'
            ]);
        }

        $kelas->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Kelas berhasil dihapus'
        ]);
    }

}
