<?php

namespace app\admin\model;


use app\common\model\TimeModel;

class SystemLog extends TimeModel
{

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->name = 'system_log';
    }

    public function setMonth($month)
    {
        $this->name = 'system_log';
        return $this;
    }

    public function admin()
    {
        return $this->belongsTo('app\admin\model\SystemAdmin', 'admin_id', 'id');
    }


}