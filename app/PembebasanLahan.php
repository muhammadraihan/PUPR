<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\Uuid;

class PembebasanLahan extends Model
{
    use Uuid;
    use LogsActivity;

    protected $fillable = [
        'pekerjaan_id',
        'kebutuhan',
        'sudah_bebas',
        'belum_bebas',
        'dokumentasi_id',
        'permasalahan',
        'tindak_lanjut',
        'created_by',
        'edited_by'
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'pembebasanLahan';

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
