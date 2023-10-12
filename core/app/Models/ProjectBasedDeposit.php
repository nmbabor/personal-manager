<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectBasedDeposit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','project_id','paid_amount','payment_date','payment_gateway','reference_no','note','received_by'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function receivedByUser(){
        return $this->belongsTo(User::class,'received_by');
    }
}
