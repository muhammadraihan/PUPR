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

    public function jenker()
    {
        return $this->belongsTo(JenisPekerjaan::class, 'jenis_pekerjaan', 'id');
    }

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id', 'id');
    }
}
