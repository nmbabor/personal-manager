<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectBasedExpense extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','total_amount','payment_date','note','paid_by'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function paidByUser(){
        return $this->belongsTo(User::class,'paid_by');
    }
    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
}
