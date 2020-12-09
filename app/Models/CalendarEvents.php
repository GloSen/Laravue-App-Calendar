<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvents extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // Tell the model which table it is to use
    protected $table = 'calendar_events';

    protected $primaryKey = 'id';

    // Mass-assignment protection prevents fields
    // from being filled by default. Tell the model which
    // fields are fillable.
    protected $fillable = [
        'event_name',
        'date',
    ];
}
