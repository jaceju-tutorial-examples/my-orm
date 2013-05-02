<?php

namespace Jace;

abstract class Record
{
    protected static $_db = null;
    protected $_tableName = 'table';
    protected $_data = [];

    public function __construct($dsn, $username, $password)
    {
        static::$_db = new \PDO($dsn, $username, $password);
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->_data)) {
            $this->_data[$name] = $value;
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        } else {
            throw new \Exception("Specified column \"$name\" is not in the \"" . get_called_class() . "\"");
        }
    }

    /**
     *
     * @return int 主鍵
     */
    public function save()
    {
        if (!isset($this->_data['id'])) {
            return $this->_doInsert();
        } else {
            return $this->_doUpdate();
        }
    }

    public function quoteIdentifier($column)
    {
        return '`' . $column . '`';
    }

    protected function _doInsert()
    {

        // 轉換欲新增的資料
        $bind = $this->_data;
        $cols = [];
        $vals = [];

        foreach ($bind as $col => $val) {
            $cols[] = $this->quoteIdentifier($col);
            $vals[] = '?';
        }

        // 建立 INSERT 語法
        $sql = "INSERT INTO "
            . $this->quoteIdentifier($this->_tableName)
            . ' (' . implode(', ', $cols) . ') '
            . 'VALUES (' . implode(', ', $vals) . ')';

        // 執行 SQL 語法並回傳影響筆數
        $stmt = static::$_db->prepare($sql);
        $stmt->execute(array_values($bind));
        $this->_data['id'] = static::$_db->lastInsertId();
        return (int) $this->_data['id'];
    }

    protected function _doUpdate()
    {
        // 轉換欲更新的資料
        $bind = $this->_data;
        $set = [];
        $i = 0;
        foreach ($bind as $col => $val) {
            unset($bind[$col]);
            if (is_array($val)) {
                $val = array_shift($val);
            } else {
                $bind[':' . $col . $i] = $val;
                $val = ':' . $col . $i;
            }
            $i ++;
            $set[] = $this->quoteIdentifier($col) . ' = ' . $val;
        }

        $where = 'id = ' . $this->_data['id'];

        // 建立 UPDATE 語法
        $sql = "UPDATE "
            . $this->quoteIdentifier($this->_tableName)
            . ' SET ' . implode(', ', $set)
            . (($where) ? " WHERE $where" : '');

        $stmt = static::$_db->prepare($sql);
        $stmt->execute($bind);
        return (int) $this->_data['id'];
    }

    public function find($id)
    {
        $sql = "SELECT * FROM ";
        $sql .= $this->quoteIdentifier($this->_tableName);
        $sql .= " WHERE id = ?";
        $stmt = static::$_db->prepare($sql);
        $stmt->execute([$id]);

        $this->_data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $this;
    }

    public function truncate()
    {
        static::$_db->exec('TRUNCATE TABLE ' . $this->quoteIdentifier($this->_tableName));
    }
}