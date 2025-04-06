<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'street',
        'city',
        'state',
    ];

    public function client()
    {
        return $this->belongsTo(Contact::class);
    }
}
