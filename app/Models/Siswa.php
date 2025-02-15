<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $fillable = ['nama_siswa', 'kelas_id', 'ortu_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    
    public function ortu()
    {
        return $this->hasOne(orangTua::class, 'id', 'ortu_id');
    }
}
