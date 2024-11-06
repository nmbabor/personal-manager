<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountDeposited extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','amount','is_withdrawn','transaction_date','type','reference','details'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public static function calculateAllUserAmounts()
    {
        // Fetch all records grouped by user_id, and eager load the user data
        return self::select('user_id')
            ->selectRaw('SUM(CASE WHEN is_withdrawn = 0 THEN amount ELSE 0 END) as total_deposit')
            ->selectRaw('SUM(CASE WHEN is_withdrawn = 1 THEN amount ELSE 0 END) as total_withdrawn')
            ->selectRaw('SUM(CASE WHEN is_withdrawn = 0 THEN amount ELSE -amount END) as final_amount')
            ->with('user')
            ->groupBy('user_id')
            ->get();
    }
    public function isEditable($minutes = 24)
    {
        $createdAt = Carbon::parse($this->created_at);
        $currentTime = Carbon::now();
        $timeDifference = $createdAt->diffInHours($currentTime);

        return $timeDifference <= $minutes;
    }
}
