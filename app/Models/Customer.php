<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserScope;

class Customer extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }


    protected $fillable = ['name','mobile_no','address','word_no','father_name','status','created_by'];

    public function dueBooks()
    {
        return $this->hasMany(CustomerDueBook::class);
    }
}
