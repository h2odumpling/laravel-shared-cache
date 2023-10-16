<?php

namespace H2o\SharedCache\Channels;

use Illuminate\Support\Facades\Cache;

abstract class AbstractCache
{
    protected $tag = 'cache';
    protected $keys = ['id'];
    protected $fields = ['*'];
    protected $filter = [];
    protected $remain = 5;
    protected $multi = false;
    protected $modelClass;

    protected $cache;

    public function __construct()
    {
        $this->tag = 'shared_' . $this->tag;
        $this->cache = Cache::tags([$this->tag]);
    }

    public function getCacheName(string $key){
        return $this->tag . '_' . $key;
    }

    public function get(string $key_name){
        $cache_name = self::getCacheName($key_name);

        $data = $this->cache->get($cache_name, function () use($cache_name, $key_name){
            $data = json_encode($this->findData($key_name));
            $this->cache->put($cache_name, $data, $this->remain);
            return $data;
        });

        return json_decode($data, true);
    }

    public function findData(string $key_name){
        $params = explode('_', $key_name);
        $model = (new $this->modelClass);

        foreach ($this->keys as $index => $key){
            $model = $model->where($key, $params[$index]);
        }

        foreach ($this->filter as $v){
            $model = $model->where($v);
        }

        if(!in_array('*', $this->fields)){
            $model = $model->select($this->fields);
        }

        $model = $this->multi ? $model->get() : $model->first();

        $model = $this->transform($model);

        return $model ? $model->toArray() : null;
    }

    protected function transform($model){
        return $model;
    }

    public function forget($key_name){
        return $this->cache->forget($this->getCacheName($key_name));
    }

    public function flushAll(){
        return $this->cache->flush();
    }

    public function getTag(){
        return $this->tag;
    }

    public function getKeys(){
        return $this->keys;
    }
}
