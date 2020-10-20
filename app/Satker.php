<?php

namespace App;
use App\Traits\Uuid;

use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    use Uuid;

    protected $fillable = [
        'nama','wilayah','created_by','edited_by'
    ];
}
