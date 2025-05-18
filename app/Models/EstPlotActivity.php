<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstPlotActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'plot_id','activity_id', 'added_at', 'user_id', 'subject',
    ];

    public $timestamps = false;

}
