<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'project_type',
        'pr_category',
        'land_type',
        'location',
        'address',
        'division_id',
        'district_id',
        'upazila_id',
        'status',
        'description',
        'user_id'
    ];

    // public function getDivision(){
    //     return $this->hasOne('App\Models\Division', 'id', 'division_id');
    // }


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

    public function userName()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function CategoryName()
    {
        return $this->belongsTo(EstateLookUp::class, 'pr_category', 'data_keys')
                            ->where('data_type','project.category');
                            
    }


}
