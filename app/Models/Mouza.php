<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouza extends Model
{
    use HasFactory;

    public function division()
    {
        return $this->belongsTo(Division::class,'division_id', 'id');
    }
    
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }

    
}
