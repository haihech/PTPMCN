<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    protected $table = 'tintuc';
    protected $fillable = [
		'id', 'anh', 'tieude','noidung','active'
	];
}
