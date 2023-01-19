<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Submission
 */
class Submission extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'workout',
        'artists'
    ];

}
