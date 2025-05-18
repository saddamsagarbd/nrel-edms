<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstPlot extends Model
{
    use HasFactory;


    public function saleStatus()
    {
        return $this->hasOne(EstPlotLookup::class, 'data_keys', 's_status',);
    }


}
