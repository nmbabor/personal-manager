<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyDeposit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','payment_month','payment_year','payable_amount','paid_amount','is_paid','payment_gateway','reference_no','note','payment_date','received_by'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['payment_month_year'];

    public function getPaymentMonthYearAttribute()
    {
        return $this->attributes['payment_year'] . '-' . $this->attributes['payment_month'];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function receivedByUser(){
        return $this->belongsTo(User::class,'received_by');
    }
}
