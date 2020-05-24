<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable=[
        'name',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
