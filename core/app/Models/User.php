<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile_no',
        'country_id',
        'password',
        'username',
        'type',
        'google_id',
        'profile_image',
        'is_google_registered',
        'is_suspended',
        'monthly_amount',
        'designation',
        'father_name',
        'mother_name',
        'word_no',
        'permanent_address',
        'peresent_address',
        'join_date',
        'deposit_start_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $appends = ['pro_pic'];

    public function getProPicAttribute()
    {
        return imageRecover($this->profile_image);
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function payments(){
        return $this->hasMany(MonthlyDeposit::class, 'user_id');
    }
    public function payment($year,$month, $coll = false){
        $amount = MonthlyDeposit::where('user_id',$this->id);
        if($coll){
            $amount =  $amount->whereYear('payment_date',$year)->whereMonth('payment_date',$month)->sum('paid_amount');
        }else{
            $amount =  $amount->where([
                'payment_month' => $month,
                'payment_year' => $year,
            ])->value('paid_amount');
        }
        return $amount;
    }

    public function dueMonths()
    {
        $joiningDate = new \DateTime($this->deposit_start_date);
        $currentDate = new \DateTime();
        $paidMonths = $this->payments->pluck('payment_month_year')->map(function ($date) {
            return (new \DateTime($date))->format('Y-m');
        });

        $dueMonths = [];

        while ($joiningDate <= $currentDate) {
            $month = $joiningDate->format('Y-m');
            if (!$paidMonths->contains($month)) {
                $dueMonths[] = $month;
            }
            $joiningDate->modify('+1 month');
        }

        return $dueMonths;
    }
}
