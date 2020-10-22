<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property integer id
 * @property integer user_id
 * @property integer status_id
 * @property string description
 * @property string name
 */
class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    /**
     * Get the User that owns the Project.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get the Status that owns the Project.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }
}
