<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'padlet_id'];

    /*
     * Ein Padlet hat mehrere Entries - ein Entry hat ein Padlet
     */

    public function padlet(): BelongsTo{
        return $this->belongsTo(Padlet::class);
    }

    /*
     * Ein Entry kann mehrere Ratings haben - ein Rating kann nur zu einem Entry gehören
     */

    public function ratings():HasMany{
        return $this->hasMany(Rating::class);
    }

    // Ein Entry kann mehrere Kommentare haben - ein Kommentar kann nur zu einem Entry gehören
    public function comments():HasMany{
        return $this->hasMany(Comment::class);
    }
/*
    //Ein Entry gehört zu einem User
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
*/

}
