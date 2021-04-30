<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taske extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'due_date',
        'user_id',
        'finished'
    ];
}
