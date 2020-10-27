<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\Uuid;

class DataKontrak extends Model
{
    use Uuid;
    use LogsActivity;

    protected $fillable = [
        'pekerjaan_id',
        'pagu',
        'nilai_kontrak',
        'panjang_jalan',
        'panjang_jembatan',
        'tahun_anggaran',
        'tanggal_kontrak_awal',
        'tanggal_adendum_kontrak',
        'tanggal_adendum_akhir',
        'tanggal_pho',
        'tanggal_fho',
        'keterangan',
        'data_teknis',
        'created_by',
        'edited_by'
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'dataKontrak';

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Data has been {$eventName}";
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id', 'uuid');
    }
}
