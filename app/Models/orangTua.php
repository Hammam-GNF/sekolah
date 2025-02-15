<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tuas';
    protected $fillable = ['nama_ortu'];
    
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
