<?php

namespace App\Traits;

use App\Document;

trait HasDocuments
{
    /**
     * This object can have many documents
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function documents()
    {
        return $this->morphToMany(Document::class, 'documentable');
    }
}
