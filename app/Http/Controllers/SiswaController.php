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
        $siswa = Siswa::with('kelas')->get();

        return response()->json([
            'status' => 200,
            'siswa' => $siswa
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
            'kelas_id' => $request->kelas_id
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $siswa = Siswa::find($id);
        if ($siswa) {
            $siswa->update($request->only(['nama_siswa', 'kelas_id']));
            return response()->json([
                'status' => 200,
                'message' => 'Siswa updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'siswa not found',
                'siswa' => $siswa
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
