<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserScope;

class CustomerDueBook extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }

    protected $fillable = [
        'start_date',
        'close_date',
        'book_no',
        'customer_id',
        'created_by',
        'updated_by',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function ladgers()
    {
        return $this->hasMany(CustomerLadger::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
