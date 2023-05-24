<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Padlet extends Model
{
    use HasFactory;

    //Ändern von Tabellennamen im Model möglich oder
    // auch setzen von primary key -> ("Mapping richtig stellen")
    //protected $table = 'padlet';
    //protected $primaryKey = 'id';

    //Mass-Asignments
    //Wenn Objekte in Datenbank speichern, muss ich angeben, welche Attribute
    //ich wenn ich REST verwende oder HTTP Request absetze, verwenden kann
    //fillable - Diese Werte darf ich mitgeben
    protected $fillable = ['title', 'isPublic'];

    //guarded - Diese Werte darf ich nicht mitgeben


    /*public function isPublic(): bool
    {
        return $this->isPublic > 1;
    }*/

    /*public static function public()
    {
        return static::where('isPublic', '>', 1)->get();
    }
*/

    //Scopes sinnvoll, wenn ich noch was dranhängen will und nicht get() automatisch
    //ausgeführt werden soll. Z.B. es soll nach allen public Padlets gesucht werden
    //die mit einem a im Titel beginnen

    public static function scopePublic($query)
    {
        return $query->where('isPublic', '>', 1);
    }

    // Ein Padlet hat mehrere Entries, ein Entry gehört immer zu einem Padlet

    public function entries():HasMany{
        return $this->hasMany(Entry::class);
    }

    //Ein Padlet gehört zu einem User, ein User kann mehrere Padlets haben
        public function users():BelongsToMany{
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
