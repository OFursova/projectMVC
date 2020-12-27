<?php
namespace Core\Models;

use core\Libs\Db;

abstract class Model {
    public static function findAll() {
        $pdo = Db::getInstance();
        return $pdo->query('SELECT * FROM '.static::getTableName(), [], static::class);
    }
    public static function getById($id) {
        $pdo = Db::getInstance();
        $result = $pdo->query('SELECT * FROM '.static::getTableName().' WHERE id=:id', ['id'=> $id], static::class);
        return $result ? $result[0] : null;
    }
    public function save()
    {
        $properties = $this->propertiesToDb();
        //echo print_r($properties, true);
        if($this->id !== null){
            $this->update($properties);
        } else {
            $this->insert($properties);
        }
        
    }
    public function propertiesToDb()
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $props = [];
        foreach($properties as $property){
            $propertyName = $property->getName();
            $props[$propertyName] = $this->$propertyName;
        }
        return $props;
    }
    private function update(array $properties)
    {
        $columns = [];
        foreach ($properties as $column => $value) {
            $columns[] = $column.'=:'.$column;
        }
        $pdo = Db::getInstance();
        $sql = 'UPDATE '.static::getTableName().' SET '.implode(', ', $columns).' WHERE id=:id';
        $pdo->query($sql, $properties, static::class);
    }
    private function insert(array $properties)
    {
        $columns = [];
        $values = [];
        $placeholders = [];
        foreach ($properties as $column => $value) {
            if ($column == 'id') {
                continue;
            } else {
            $columns[] = $column;
            $values[] = $value;
            $placeholders[] = '?';
            }
        }
        $pdo = Db::getInstance();
        $sql = 'INSERT INTO '.static::getTableName().' ('.implode(', ', $columns).') VALUES ('.implode(', ', $placeholders).')';
        //echo $sql;
        //print_r($values);
        $pdo->query($sql, $values, static::class);

    }
    public function delete($id)
    {
        $pdo = Db::getInstance();
        $result = $pdo->query('DELETE FROM '.static::getTableName().' WHERE id=:id', ['id'=> $id], static::class);
    }
    abstract protected static function getTableName();
}