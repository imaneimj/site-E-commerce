<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // Specify the table associated with the model (optional if you follow naming conventions)
    protected $table = 'addresses';

    // Define which attributes are mass assignable
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'locality',
        'address',
        'city',
        'state',
        'country',
        'landmark',
        'zip',
        'type',
        'isdefault',
    ];

    // Define relationships if needed, for example with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
