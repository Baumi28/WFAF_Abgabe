<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Right extends Model
{
    use HasFactory;

    protected $fillable = ['access', 'padlet_id', 'user_id'];
}
