<?php

namespace App\Contracts;

interface RecordsActivities
{
    public function activities();

    public function author();

    public function getUrlAttribute();
}
