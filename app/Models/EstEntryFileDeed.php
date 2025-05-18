<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstEntryFileDeed extends Model
{
    use HasFactory;


    public function deedBuyer()
    {
        return $this->belongsTo(EstateLookUp::class,'buyer', 'data_keys')
                    ->where('estate_look_ups.data_type','entryfile.buyer');
    }
    
}
