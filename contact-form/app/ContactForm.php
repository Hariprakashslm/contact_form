<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    public function LocationMaster(){
		return $this->belongsTo('App\LocationMaster','Location','id');  
	}
}
