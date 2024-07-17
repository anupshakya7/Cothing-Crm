<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = ['company_name', 'logo', 'copyright', 'multilanguage', 'default_language', 'address', 'email', 'phone', 'map'];
}
