<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spesialisasi extends Model
{
    protected $table = 'spesialisasi';

    protected $fillable = ['nama'];

    public function staffSdm(): HasMany
    {
        return $this->hasMany(StaffSdm::class, 'spesialisasi_id');
    }
}
