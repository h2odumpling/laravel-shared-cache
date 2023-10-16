<?php

namespace H2o\SharedCache\Channels;

use App\Model\ExampleModel;

class ExampleCache extends AbstractCache
{
    protected $tag = 'dividend_chain';
    protected $remain = 5;
    // protected $keys = ['lid', 'device_type_id'];
    protected $filter = [
//        ['status' => DividendConstant::CHAIN_STATUS_NORMAL]
    ];
    protected $modelClass = ExampleModel::class;
}
