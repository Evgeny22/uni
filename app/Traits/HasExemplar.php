<?php

namespace App\Traits;

use App\Exemplar;
use Auth;
use Exception;

trait HasExemplar
{
    /**
     * This object can be exemplar
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function exemplar()
    {
        return $this->exemplars()->orderBy('updated_at',"DESC")->first();
    }

    /**
     * Get mutator for the isExemplar attribute
     *
     * @param mixed $value
     * @return bool
     */
    public function getIsExemplarAttribute($value)
    {
        return $this->exemplar() ? $this->exemplar()->approved == 1 : false;
    }

    /**
     * Get mutator for the HasExemplarRequest attribute
     *
     * @param mixed $value
     * @return bool
     */
    public function getHasExemplarRequestAttribute($value)
    {
        return $this->exemplar() && $this->exemplar()->approved == 0 ? true : false;
    }
}
