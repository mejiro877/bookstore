<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineMember extends Model
{
    protected $fillable = [
        'member_no', 'password', 'name', 'age', 'sex', 'zip', 'address', 'tel', 'register_date', 'delete_flg', 'last_upd_date',
    ];
    protected $table = 'online_member';
    public $timestamps = false;
    protected $primaryKey = 'member_no';
}
