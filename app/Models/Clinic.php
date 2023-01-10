<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'country_id',
        'name',
        'serial',
        'key',
        'description',
        'manager',
        'code',
        'address',
        'postcode',
        'city',
        'phone',
        'website',
        'email',
        'logo'
    ];

    protected $dates = ['deleted_at'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
