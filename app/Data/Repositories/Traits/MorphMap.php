<?php

namespace App\Data\Repositories\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait MorphMap
{

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::bootTraits();

        static::loadMorphMap();
    }

    /**
     * Load morph map relation
     *
     * @return void
     */
    protected static function loadMorphMap()
    {
        Relation::morphMap([]);
    }
}
