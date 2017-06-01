<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietThu extends Model
{
    protected $table = 'chitietthu';
    protected $fillable = [
		'id', 'sotienthu', 'hoadonxuat_id', 'phieuthu_id',
	];
}
