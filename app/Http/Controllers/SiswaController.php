<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('siswa.index');
    }
    public function getall()
    {
        $siswa = Siswa::with('kelas', 'ortu')->get();

        return response()->json([
            'status' => 200,
            'siswa' => $siswa
        ]);
    }

    public function count()
    {
        $totalSiswa = Siswa::count();
        return response()->json([
            'status' => 200,
            'totalSiswa' => $totalSiswa
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
            'nama_siswa' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'ortu_id' => 'required|exists:orang_tuas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $siswa = Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas_id' => $request->kelas_id,
            'ortu_id' => $request->ortu_id
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Siswa berhasil ditambahkan!',
            'siswa' => $siswa
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:siswas,id',
            'nama_siswa' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'ortu_id' => 'required|exists:orang_tuas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $siswa = Siswa::find($request->id);
        if ($siswa) {
            $siswa->update($request->only(['nama_siswa', 'kelas_id', 'ortu_id']));
            return response()->json([
                'status' => 200,
                'message' => 'Siswa updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Siswa not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'status' => 404,
                'message' => 'Siswa tidak ditemukan'
            ]);
        }

        $siswa->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Siswa berhasil dihapus'
        ]);
    }
}
