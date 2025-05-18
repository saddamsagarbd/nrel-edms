<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstEntryFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_no', 'user_id','project_id', 'agent_id', 'landowners', 'buyer_id','buyer_company','mouza_id','khatype_id','remarks', 'tland_size','tland_cost','deed_type','deed_status','status'
    ];

    public function agent()
    {
        return $this->belongsTo(EstateVendor::class,'agent_id', 'id');
    }
    
    public function mouza()
    {
        return $this->belongsTo(Mouza::class,'mouza_id', 'id');
    }

    public function khatianType()
    {
        return $this->belongsTo(EstateLookUp::class,'khatype_id', 'data_keys')
                        ->where('data_type', 'khatian');
    }
    

    public function project()
    {
        return $this->hasOne(EstateProject::class, 'id', 'project_id',);
    }

    public function entryDagData()
    {
        return $this->hasMany(EstEntryFileDag::class, 'entfile_id', 'id')
                        ->leftJoin('khatian_dag_infos','khatian_dag_infos.id', 'est_entry_file_dags.dag_id')
                        ->select('khatian_dag_infos.dag_no','khatian_dag_infos.khatian_no','khatian_dag_infos.id', 'khatian_dag_infos.csdag_id','khatian_dag_infos.sadag_id','khatian_dag_infos.rsdag_id','khatian_dag_infos.khatian_land','est_entry_file_dags.*' );
    }
    // public function entryDeed1()
    // {
    //     return $this->hasMany(EstEntryFileDeed::class, 'entfile_id', 'id')
    //                 ->leftJoin('estate_look_ups','est_entry_file_deeds.deed_type', 'estate_look_ups.id')
    //                 ->leftJoin('estate_look_ups as buyerLook','est_entry_file_deeds.buyer', 'buyerLook.id')
    //                 ->select('estate_look_ups.data_keys as deed_name','buyerLook.data_keys as buyer_name','est_entry_file_deeds.*' );;
    // }

    // public function entryDeed()
    // {
    //     return $this->hasMany(EstEntryFileDeed::class, 'entfile_id', 'id')
    //                 ->leftJoin('estate_look_ups','est_entry_file_deeds.deed_type', 'estate_look_ups.data_keys')
    //                 ->select("estate_look_ups.data_values as deed_name",'est_entry_file_deeds.*' )
    //                 ->where('estate_look_ups.data_type','deed.type');
    // }

    public function entryDeed()
    {
        return $this->hasMany(EstEntryFileDeed::class, 'entfile_id', 'id');
    }

    public function entryMutation()
    {
        return $this->hasMany(EstEntryFileMutation::class, 'entryfile_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(EstateFile::class, 'entryfile_id', 'id');
    }


    public function buyerName()
    {
        return $this->belongsTo(EstateLookUp::class,'buyer_id', 'data_keys')->where('data_type','entryfile.buyer');
    }


    public function entFileStatus()
    {
        return $this->hasOne(EstateLookUp::class, 'data_keys', 'status')
                    ->where('data_type', 'entryfile.status');
    }

    public function entLandowners()
    {
        return $this->hasMany(EstateVendor::class, 'id', 'landowners');
    }

    public function userInfo()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    protected $casts = [
        'landowners' => 'array',
    ];

    public function landownersData()
    {
        return $this->belongsToMany(EstateVendor::class, 'est_entry_files', 'landowners', 'id');
    }

}
