<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
	use HasFactory;

	protected $fillable = ['user_id'];

	public function user(){
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function getCountry()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function getState()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function getCity()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

}
