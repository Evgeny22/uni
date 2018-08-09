<?php

namespace App;

use Illuminate\Support\Collection;

class AnswerCollection
{
    /**
     * The laravel collection of answers
     *
     * @var Illuminate\Support\Collection
     */
    protected $collection;

    /**
     * Constructs a new answer collection
     *
     * @param Illuminate\Support\Collection $collection
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Convenience method for finding an answer by key, getting it's value
     * or displaying a fallback
     *
     * @param string $key
     * @return string
     */
    public function get($key, $fallback = '')
    {
        $answer = $this->collection->where('key', $key)->first();

        return object_get($answer, 'value', $fallback);
    }
}
