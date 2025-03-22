<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name','mobile_no','address','word_no','father_name','status','created_by'];

    public function ladgers()
    {
        return $this->hasMany(CustomerLadger::class);
    }
}
