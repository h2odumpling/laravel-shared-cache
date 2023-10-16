<?php

namespace H2o\SharedCache;


use H2o\SharedCache\Exceptions\ClassNotExistsException;

class SharedCache
{
    protected $channel = 'default';
    public function channel(string $channel){
        $className = config('shared-cache.channel_namespace') . ucfirst(
            preg_replace_callback('/_([a-z])/i', function ($match){
                return ucfirst($match[1]);
            }, $channel)
        ) . 'Cache';

        if (!class_exists($className))
            throw new ClassNotExistsException();

        return new $className;
    }
}
