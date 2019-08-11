<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'schedule_date'];

    /**
     * So we could just assigned with date in y-m-d string.
     * 
     * @param string $value
     * @return void
     */
    public function setScheduleDate($value) {
        $this->attributes['schedule_date'] = Carbon::createFromFormat('y-m-d', $value);
    }
}
