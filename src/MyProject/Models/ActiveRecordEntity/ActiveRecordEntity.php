<?php

namespace MyProject\Models\ActiveRecordEntity;

use MyProject\Models\Articles\Article;
use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelToUnderScore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelToUnderScore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    private function update(array $mappedProperties)
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index;
            $columns2params[] = $column . ' = ' . $param;
            $params2values[$param] = $value;
            $index++;
        }

        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->getId();

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties)
    {

        $mappedPropertiesNotNull = array_filter($mappedProperties);
        $columns = [];
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedPropertiesNotNull as $column => $value) {
            $param = ':param' . $index;
            $columns2params[] = $param;
            $columns[] = $column;
            $params2values[$param] = $value;
            $index++;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $columns) . ') ' . ' VALUES ' . ' (' . implode(', ', $columns2params) . ');';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
    }

    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    public static function getById(int $id): ?static
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public function save()
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    public function delete(): void
    {
        $id = ['id' => $this->id,];
        $db = Db::getInstance();
        $sql = 'DELETE FROM ' . static::getTableName() . ' WHERE id = :id;';

        $db->query($sql, $id, static::class);
        $this->id = null;
    }

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();

        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        if($result === []) {
            return null;
        }

        return $result[0];
    }

    abstract protected static function getTableName(): string;
}