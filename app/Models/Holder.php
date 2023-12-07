<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holder extends Model
{
    use HasFactory;
    protected $table = 'holder';
    protected $fillable = [
        'RasiId',
        'date',
        'userId'
    ];
}
