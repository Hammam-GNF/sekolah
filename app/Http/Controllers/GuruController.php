<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('guru.index');
    }

    public function getall()
    {
        $guru = Guru::with('kelas')->get();

        return response()->json([
            'status' => 200,
            'guru' => $guru
        ]);
    }

    public function count()
    {
        $totalGuru = Guru::count();
        return response()->json([
            'status' => 200,
            'totalGuru' => $totalGuru
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
            'nama_guru' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $guru = Guru::create([
            'nama_guru' => $request->nama_guru,
            'kelas_id' => $request->kelas_id
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Guru berhasil ditambahkan!',
            'guru' => $guru
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:gurus,id',
            'nama_guru' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $guru = Guru::find($request->id);
        if ($guru) {
            $guru->update($request->only(['nama_guru', 'kelas_id']));
            return response()->json([
                'status' => 200,
                'message' => 'guru updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'guru not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json([
                'status' => 404,
                'message' => 'guru tidak ditemukan'
            ]);
        }

        $guru->delete();

        return response()->json([
            'status' => 200,
            'message' => 'guru berhasil dihapus'
        ]);
    }
}
