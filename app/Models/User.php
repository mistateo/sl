<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

//No login/authentication for this sample app, no need to extend Laravel user object

/**
 * Class User
 * @package App\Models
 * @property string email
 * @property string first_name
 * @property string last_name
 * @property array tags
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'tags'
    ];
}
