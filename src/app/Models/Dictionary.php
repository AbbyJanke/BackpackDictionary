<?php

namespace AbbyJanke\BackpackDictionary\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Dictionary extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'dictionary';
    protected $primaryKey = 'id';
    protected $fillable = ['word', 'definition'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_word',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrWordAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->word;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function related($relationship = 'basic')
    {
      return $this->belongsToMany('AbbyJanke\BackpackDictionary\app\Models\Dictionary', 'dictionary_related', 'parent_id', 'child_id')->wherePivot('relationship', $relationship);
    }
}
