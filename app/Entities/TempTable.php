<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class TempTable extends Model
{
    protected $table = "temp_import_tbl";

    protected $guarded  = [];
}
