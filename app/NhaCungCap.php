<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    protected $table = 'nhacungcap';
    protected $fillable = [
		'id', 'ten', 'diachi', 'sdt', 'email', 'fax', 'sotk', 'masothue',
	];
}
