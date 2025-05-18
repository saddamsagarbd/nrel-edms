<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateVendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'father_name',
        'mother_name',
        'birth_date',
        'nid',
        'project_id',
        'client_type',
        'user_id',
    ];
    

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }
    public function union()
    {
        return $this->belongsTo(Union::class);
    }

    public function project()
    {
        return $this->belongsTo(EstateProject::class, 'project_id', 'id');
    }
    
}
