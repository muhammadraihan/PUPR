<?php

namespace App;
use App\Traits\Uuid;

use Illuminate\Database\Eloquent\Model;

class JenisPekerjaan extends Model
{
    use Uuid;
    protected $fillable = [
        'nama','created_by','edited_by'
    ];
}
