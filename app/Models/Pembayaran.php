<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'tahun_ajaran', 'siswa_id', 'kelas', 'bulan', 'tahun',
        'jenis_pembayaran', 'nominal', 'status', 'tanggal_bayar', 'kwitansi_no', 'keterangan',
    ];

    protected $casts = [
        'nominal' => 'decimal:0',
        'tanggal_bayar' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public static function generateKwitansiNo(): string
    {
        $prefix = 'KW-' . date('Ymd') . '-';
        $last = self::where('kwitansi_no', 'like', $prefix . '%')->orderByDesc('id')->first();
        $seq = $last ? (int) substr($last->kwitansi_no, strlen($prefix)) + 1 : 1;
        return $prefix . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }
}
