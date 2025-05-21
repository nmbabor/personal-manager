<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserScope;

class CustomerLadger extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
    
    protected $fillable = ['status', 'amount', 'type', 'date', 'details','customer_due_book_id', 'customer_id', 'created_by', 'updated_by'];

    public function customerDueBook()
    {
        return $this->belongsTo(customerDueBook::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
