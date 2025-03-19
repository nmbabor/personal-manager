<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','details','address','reference','completed_date','status'];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function incomes()
    {
        return $this->hasMany(ProjectBasedDeposit::class);
    }

    public function expenses()
    {
        return $this->hasMany(ProjectBasedExpense::class);
    }

    public function totalIncome()
    {
        return $this->incomes->sum('paid_amount');
    }

    public function totalExpense()
    {
        return $this->expenses->sum('total_amount');
    }

    public function isEditable($minutes = 24)
    {
        $createdAt = Carbon::parse($this->created_at);
        $currentTime = Carbon::now();
        $timeDifference = $createdAt->diffInHours($currentTime);

        return $timeDifference <= $minutes;
    }
}
