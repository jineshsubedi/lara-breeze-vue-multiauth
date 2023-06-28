<?php

namespace Hris\Travel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelExpense extends Model
{
    use HasFactory;

    protected $fillable = array('travel_id', 'destination_id', 'type', 'ticket', 'lodging', 'phone', 'local_conveyance', 'breakfast', 'lunch', 'dinner', 'others', 'total', 'date', 'description');

    public function destination()
    {
        return $this->belongsTo(TravelDestination::class, 'destination_id');
    }
}
