<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture',
        'plan_id',
        'first_name',
        'last_name',
        'id_type',
        'id_number',
        'phone',
        'birthdate',
        'gender',
        'registration_date',
        'address',
        'country',
        'locality',
        'province',
        'postal_code',
        'emergency_contact',
        'rgpd_consent',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Un usuario pertenece a un plan de membresía
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Un usuario puede reservar muchas clases (eventos)
    public function events()
    {
        return $this->belongsToMany(Event::class)
                    ->withPivot('status')
                    ->withTimestamps();
    }

    // Un usuario puede tener asignadas muchas rutinas
    public function routines()
    {
        return $this->belongsToMany(Routine::class)
                    ->withTimestamps()
                    ->withPivot('is_deleted');
    }

    // Un usuario tiene muchos registros de acceso
    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }

    /**
     * Comprueba si el usuario está actualmente dentro del gimnasio.
     */
    public function isInside()
    {

            //  El estado "dentro" ahora solo cuenta para el día actual.

        return $this->accessLogs()
            ->whereNull('exit_time')
            ->whereDate('entry_time', now()->toDateString())
            ->exists();
    }
}

