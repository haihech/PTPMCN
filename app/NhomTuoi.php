<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhomTuoi extends Model
{
    protected $table = 'nhomtuoi';
    protected $fillable = [
		'id', 'tuoi',
	];
	public function getAll(){
		return $this->get();
	}
}
