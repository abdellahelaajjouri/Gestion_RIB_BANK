<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    use HasFactory;
    protected $fillable = ['rib', 'raison_sociale', 'date_envoi', 'nne','user_id'];
}
