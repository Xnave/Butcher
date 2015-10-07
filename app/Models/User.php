<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['first_name', 'last_name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token', 'is_admin'];

	public function sales(){
		return $this->hasMany('Sale');
	}

	public function brands(){
		return $this->belongsToMany('Brand', 'user_brands')->withTimestamps()->withPivot('grading');
	}

	public function stores(){
		return $this->belongsToMany('Store', 'user_stores')->withTimestamps()->withPivot('grading');
	}

	public function watchedSales(){
		return $this->belongsToMany('Sale', 'user_watched_sales')->withTimestamps()->withPivot('grading');
	}
}
