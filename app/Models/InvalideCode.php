<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvalideCode extends Model
{
    use HasFactory;
    protected $table = 'table_invalid_codes';
    
    protected $fillable = [
        "reference_facture",   
        "userId"
    ];
}
