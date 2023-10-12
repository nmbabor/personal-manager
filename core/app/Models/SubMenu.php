<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id','name','url','status','serial_num'];

    public function menu(){
        return $this->belongsTo(Menu::class,'menu_id','id');
    }
}
