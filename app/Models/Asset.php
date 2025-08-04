<?php

namespace App\Models;


    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'serial_number',
        'kategori', // Tambahkan semua field yang akan di isi
        'status', // Jika kamu pakai relasi kategori
        'kondisi', // Jika kamu pakai relasi kategori
        'lokasi', // Jika kamu pakai relasi kategori
        'image', // Jika kamu pakai relasi kategori
        'qr_code_path', // Jika kamu pakai relasi kategori
        'assigned_to', // Jika kamu pakai relasi kategori
        'invoice_file',
        'assigned_at', // Jika kamu pakai relasi kategori
    ];

    protected $casts = [
        'assigned_at' => 'date',
    ];
    
    // Relasi ke AssetMutation
    public function mutations()
    {
        return $this->hasMany(\App\Models\AssetMutation::class);
    }


    // Rekasi ke User
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    
}
