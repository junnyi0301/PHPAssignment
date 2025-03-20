<?php

class DatabaseManagement
{

    public function __construct() {}
    public function createDatabase()
    {
        // code to create database
    }

    public function dropDatabase()
    {
        // code to drop database
    }

    public function fetchOne($model, $where, $params)
    {
        $table = $model::where($where, $params)->first();
        return true;
    }

    public function insert($table, $columns, $values)
    {
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        return true;
    }
}
