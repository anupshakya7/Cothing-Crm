<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    public function user()
    {
    	return $this->belongsTo(User::class, 'handled_by');
    }

    public function followUpDates()
    {
        return $this->hasMany(FollowUpDate::class);
    }
}
