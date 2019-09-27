<?php

namespace App\Models;

use Eloquent as Model;

use Lcobucci\JWT\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Str;
use App\Notifications\VerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use LogsActivity, Notifiable;

    protected static $logFillable = true;

    public $table = 'users';

    public $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'active',
        'package_id',
        'role_id',
        'id_one_signal',
        'email_verified_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'username' => 'string',
        'email' => 'string',
        'password' => 'string',
        'email_verified_at'  => 'string',
        'role_id' => 'string',
        'id_one_signal' => 'string'
    ];

    protected $hidden = [
        'password', 'remember_token'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required',
        'username' => 'unique:users, username'
    ];

    public function generateAccessToken()
    {
        $uuid = Str::uuid()->toString();
        $token = (string) (new Builder())
            ->setId($uuid, true)
            ->setIssuedAt(time())
            ->setExpiration(time() + 120) //1290600 == 14day
            ->set('username', $this->first_name)
            ->set('email', $this->email)
            ->set('id', $this->id)
            ->getToken();

        return $token;
    }

    public function files()
    {
        return $this->hasMany('App\Models\File', 'user_id', 'id');
    }

    public function company()
    {
        return $this->hasOne(\App\Models\Company::class, 'owner_id');
    }

    public function package()
    {
        return $this->hasOne('App\Models\Package', 'id', 'package_id');
    }

    public function setting()
    {
        return $this->hasOne('App\Models\Setting', 'id', 'package_id');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'user_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'user_id', 'id');
    }

    public function seller()
    {
        return $this->hasOne('App\Models\Seller', 'user_id', 'id');
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail); // my notification
    }
}
