<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhatianDagInfo extends Model
{
    use HasFactory;

    public function mouza(){
        return $this->belongsTo(Mouza::class);
    }

    public function csDag(){
        return $this->belongsTo(KhatianDagInfo::class, 'csdag_id', 'id');
    }
    public function saDag(){
        return $this->belongsTo(KhatianDagInfo::class, 'sadag_id', 'id');
    }
    public function rsDag(){
        return $this->belongsTo(KhatianDagInfo::class, 'rsdag_id', 'id');
    }

    public function parentDag(){
        return $this->belongsTo(KhatianDagInfo::class, 'parent_id', 'id');
    }

    public function dag()
    {
        return $this->hasOne(EstateLookUp::class, 'id', 'khatian_type');
    }

}
