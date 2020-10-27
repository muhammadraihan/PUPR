<?php

namespace App;
use App\Traits\Uuid;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use Uuid;

    protected $fillable = [
        'title','jenis_pekerjaan','satker_id','tahun_mulai','tahun_selesai'
    ];

    protected static $logAttributes = ['*'];

    /**
     * Logging name
     *
     * @var string
     */
    protected static $logName = 'pekerjaan';

    /**
     * Logging only the changed attributes
     *
     * @var boolean
     */
    protected static $logOnlyDirty = true;

    /**
     * Prevent save logs items that have no changed attribute
     *
     * @var boolean
     */
    protected static $submitEmptyLogs = false;

    /**
     * Custom logging description
     *
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Data has been {$eventName}";
    }

    public function jenker()
    {
        return $this->belongsTo(JenisPekerjaan::class, 'jenis_pekerjaan', 'uuid');
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id', 'uuid');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'edited_by', 'uuid');
    }
}
