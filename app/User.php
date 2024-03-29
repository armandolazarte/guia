<?php

namespace Guia;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
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
    protected $fillable = ['username', 'email', 'password', 'nombre', 'cargo', 'prefijo', 'iniciales', 'active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    //User __belongs_to_many__ Roles
    public function roles()
    {
        return $this->belongsToMany('Guia\Models\Role');
    }

    //User __belongs_to_many__ Grupo
    public function grupos()
    {
        return $this->belongsToMany('Guia\Models\Grupo')->withPivot('supervisa','administra');
    }

    //User __has_many__ Acceso
    public function accesos()
    {
        return $this->hasMany('Guia\Models\Acceso');
    }

    //User __has_many__ Registro
    public function registros()
    {
        return $this->hasMany('Guia\Models\Registro');
    }

    //User __has_many__ PreReq
    public function preReqs()
    {
        return $this->hasMany('Guia\Models\PreReq');
    }

    //User __has_many__ Req
    public function reqs()
    {
        return $this->hasMany('Guia\Models\Req');
    }

    //User __has_many__ Solicitud
    public function solicitudes()
    {
        return $this->hasMany('Guia\Models\Solicitud');
    }

    //User __has_many__ Comp
    public function comps()
    {
        return $this->hasMany('Guia\Models\Comp');
    }

    //User __has_many__ Egreso
    public function egresos()
    {
        return $this->hasMany('Guia\Models\Egreso');
    }

    //User __morph_many__ RelacionInterna
    public function relInternas()
    {
        return $this->morphMany('Guia\Models\RelInterna', 'destino');
    }

    /**
     * El usuario asigna su cuenta a otros usuarios
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignaUsuarios()
    {
        return $this->hasMany('Guia\Models\AsignaUsuario', 'user_id', 'id');
    }

    /**
     * El usuario tiene cuentas de usuarios asignados
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuariosAsignados()
    {
        return $this->hasMany('Guia\Models\AsignaUsuario', 'asignado_user_id', 'id');
    }
}
