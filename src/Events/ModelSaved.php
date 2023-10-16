<?php

namespace H2o\SharedCache\Events;

use H2o\SharedCache\Interfaces\SharedChannels;

class ModelSaved
{
    public $model;

    public function __construct(SharedChannels $model)
    {
        $this->model = $model;
    }
}
