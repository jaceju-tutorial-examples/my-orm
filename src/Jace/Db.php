<?php

namespace Jace;

class Db
{
    public static function factory($type, $options)
    {
        return new Db\Driver\Mysql();
    }

    public function query($sql, $bind = [])
    {

    }

    public function insert($tableName, $data)
    {

    }

    public function update($tableName, $data, $conditions)
    {

    }

    public function delete($tableName, $conditions)
    {

    }
}