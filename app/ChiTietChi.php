<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietChi extends Model
{
    protected $table = 'chitietchi';
    protected $fillable = [
		'id', 'sotienchi', 'hoadonnhap_id', 'phieuchi_id',
	];
}
