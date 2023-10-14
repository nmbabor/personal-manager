<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyClosingAmount extends Model
{
    use HasFactory;

    protected $fillable = ['closing_amount','closing_year','closing_date','closed_by'];
}
