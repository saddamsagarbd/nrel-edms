<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateFile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'entryfile_id',
        'file_name',
        'orgi_name',
        'file_path',
        'file_type',
        'file_size',
        'shelf_no',
        'doc_type',
        'doc_desc',
        'user_id'
    ];
    
}
