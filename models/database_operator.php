<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/path.php";

/*
 * Модель работы с базой данных
 */


class DataBaseOperator
{
    public $connection;

    public function __construct()
    {
        require_once BASE_DIR . "/db_config.php";

        $settings = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

        $this->connection = new PDO("mysql:host=$host;dbname=$dbase_name;charset=utf8", $user, $pass, $settings);
    }


    public function errorHandle($query) {
        $error_info = $query->errorInfo();
        if ($error_info[0] !== PDO::ERR_NONE) {
            echo $error_info[2];
            exit();
        }
        return true;
    }


    public function prepareFilter($filter) {

        # Создание строки с условиямии для выборки из базы

        $query = "";
        if (count($filter) < 1) return $query;

        $first_key = array_key_first($filter);
        $query .= " WHERE " . $first_key . " = '" . $filter[$first_key] . "'";
        unset($filter[$first_key]);
        foreach ($filter as $key => $value) {
            $query .= " AND " . $key . " = '$value'";
        }
        return $query;
    }


    public function prepareValues($values) {

        # Создание элементов строки для запроса на обновление данных(имена столбцов и значения для них)

        $str = '';
        if (count($values) < 1) return $str;
        foreach ($values as $key => $value) {
            $str .= "$key = '$value', ";
        }
        return substr($str, 0, -2);
    }

    public function prepareAdd($data) {

        # Создание элементов строки запроса на добавление(имена столбцов и значения для них)

        $columns = "(";
        $keys = "(";
        $values = [];
        foreach ($data as $key => $val) {
            $columns .= "$key, ";

            $current_key = ":$key";
            $values = $values + [$current_key => $val];

            $keys .= "$current_key, ";
        }
        $columns = substr($columns, 0, -2) . ")";
        $keys = substr($keys, 0, -2) . ")";

        return ['columns' => $columns, 'keys' => $keys, 'values' => $values];


    }


    public function getRecords($table, $filter=[]) {
        $query = "SELECT * from $table" . $this->prepareFilter($filter);

        $current_action = $this->connection->prepare($query);
        $current_action->execute();

        $this->errorHandle($current_action);

        return $current_action->fetchAll();
    }


    public function addRecord($table, $values) {

        $prepareData = $this->prepareAdd($values);

        $query = "INSERT $table " . $prepareData['columns'] . " VALUE " . $prepareData['keys'];

        $current_action = $this->connection->prepare($query);
        $current_action->execute($prepareData['values']);

        $this->errorHandle($current_action);

        return $this->connection->lastInsertId();
    }


    public function getRecord($table, $filter=[]) {
        $query = "SELECT * from $table" . $this->prepareFilter($filter) . " LIMIT 1";

        $current_action = $this->connection->prepare($query);
        $current_action->execute();

        $this->errorHandle($current_action);

        return $current_action->fetch();
    }


    public function updateRecords($table, $values, $filter=[]) {
        if (count($values) < 1) return null;
        $query = "UPDATE $table SET " . $this->prepareValues($values) . $this->prepareFilter($filter);
        $current_action = $this->connection->prepare($query);
        $current_action->execute();

        $this->errorHandle($current_action);

        return $current_action->fetchAll();
    }


    public function deleteRecords($table, $filter=[]) {
        $query = "DELETE FROM $table" . $this->prepareFilter($filter);

        $current_action = $this->connection->prepare($query);
        $current_action->execute();

        $this->errorHandle($current_action);

        return $current_action->rowCount();
    }

}