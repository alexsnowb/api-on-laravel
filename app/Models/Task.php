<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed description
 * @property int|mixed project_id
 * @property mixed user_id
 * @property mixed status_id
 * @property mixed period
 * @property mixed body
 * @property mixed method
 * @property mixed url
 * @property mixed lastRunTime
 */
class Task extends Model
{
    use HasFactory;

    const METHOD_GET      = 'GET';
    const METHOD_POST     = 'POST';
    const METHOD_PUT      = 'PUT';
    const METHOD_DELETE   = 'DELETE';

    const PERIOD_EVERY_MINUTE       = 'everyMinute';
    const PERIOD_EVERY_FIVE_MINUTES = 'everyFiveMinutes';
    const PERIOD_EVERY_TEN_MINUTES  = 'everyTenMinutes';
    const PERIOD_HOURLY             = 'hourly';
    const PERIOD_DAILY              = 'daily';
    const PERIOD_MONTHLY            = 'monthly';

    /**
     * @return string[]
     */
    public static function methodList()
    {
        return [
            self::METHOD_GET    => 'GET',
            self::METHOD_POST   => 'POST',
            self::METHOD_DELETE => 'DELETE',
            self::METHOD_PUT    => 'PUT'
        ];
    }

    /**
     * @return string[]
     */
    public static function periodList()
    {
        return [
            self::PERIOD_EVERY_MINUTE       => 'Every minute',
            self::PERIOD_EVERY_FIVE_MINUTES => 'Every five minutes',
            self::PERIOD_EVERY_TEN_MINUTES  => 'Every ten minutes',
            self::PERIOD_HOURLY             => 'Hourly',
            self::PERIOD_DAILY              => 'Daily',
            self::PERIOD_MONTHLY            => 'Monthly',
        ];
    }

    /**
     * Get the User that owns the Task.
     *
     * @return User|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get the Status that owns the Task.
     *
     * @return Status|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    /**
     * Get the Status that owns the Task.
     *
     * @return Project|\Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }
}
