<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'from_user_id',
        'to_user_id',
        'dari',
        'ke',
        'tanggal',
        'notes',
    ];

    // Relasi ke Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
