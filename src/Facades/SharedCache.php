<?php

namespace H2o\SharedCache\Facades;

class SharedCache extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sharedCache';
    }
}
