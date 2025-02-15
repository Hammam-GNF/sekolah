<?php

namespace App\Http\Controllers;

use App\Models\orangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrangTuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ortu.index');
    }

    public function getall()
    {
        $ortu = orangTua::all();

        return response()->json([
            'status' => 200,
            'ortu' => $ortu
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
            'nama_ortu' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $ortu = orangTua::create([
            'nama_ortu' => $request->nama_ortu
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Data OrangTua berhasil ditambahkan!',
            'ortu' => $ortu
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(orangTua $orangTua)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orangTua $orangTua)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orang_tuas,id',
            'nama_ortu' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $ortu = orangTua::find($request->id);
        if ($ortu) {
            $ortu->update($request->only(['nama_ortu']));
            return response()->json([
                'status' => 200,
                'message' => 'Orang Tua updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Ortu not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ortu = orangTua::find($id);

        if (!$ortu) {
            return response()->json([
                'status' => 404,
                'message' => 'Orang Tua tidak ditemukan'
            ]);
        }

        $ortu->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Orang Tua berhasil dihapus'
        ]);
    }
}
