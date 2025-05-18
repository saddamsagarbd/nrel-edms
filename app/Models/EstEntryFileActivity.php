<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstEntryFileActivity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'activity_id',
        'entry_id',
        'user_id',
        'data',
        'added_at'
    ];
}
