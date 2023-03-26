<?php
class Vehicle
{
    private $make, $type, $class;
    private $year, $model, $price;

    public function __construct($make, $type, $class, $year, $model, $price)
    {
        $this->make = $make;
        $this->type = $type;
        $this->class = $class;
        $this->year = $year;
        $this->model = $model;
        $this->price = $price;
    }

    public function getMake()
    {
        return $this->make;
    }

    public function setMake($make)
    {
        $this->make = $make;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function formatPrice()
    {
        return '$' . number_format($this->price, 2, '.', ',') . '';
    }
}

function get_query_expressions($arr)
{
    $query_array = array();
    foreach ($arr as $key => $value) {
        if ($value != '') {
            $query_array[] = $key . ' = ' . $value;
        }
    }
    return $query_array;
}

function getVehicles()
{
    global $db;
    $query = "SELECT * FROM vehicles ORDER BY price DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();
    $vehicles = [];
    foreach ($rows as $row) {
        $make = get_make($row['make_id']);
        $type = get_type($row['type_id']);
        $class = getClass($row['class_id']);
        $vehicle = new Vehicle($make, $type, $class, $row['year'], $row['model'], $row['price']);
        $vehicles[] = $vehicle;
    }
    return $vehicles;
}

function filterVehicles($sort_by, $filters)
{
    global $db;
    $query = "SELECT * FROM vehicles";
    $query_array = get_query_expressions($filters);
    if (count($query_array) > 0) {
        $query .= ' WHERE ';
        $query .= implode(' AND ', $query_array);
    }
    $query .= " ORDER BY {$sort_by} DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();
    $vehicles = [];
    foreach ($rows as $row) {
        $make = get_make($row['make_id']);
        $type = get_type($row['type_id']);
        $class = getClass($row['class_id']);
        $vehicle = new Vehicle($make, $type, $class, $row['year'], $row['model'], $row['price']);
        $vehicles[] = $vehicle;
    }

    return $vehicles;
}

function add_vehicle($year, $model, $price, $make_id, $type_id, $class_id)
{
    global $db;
    $count = 0;
    $query = "INSERT INTO vehicles (year, model, price, make_id, type_id, class_id)
                        VALUES (:year, :model, :price, :make_id, :type_id, :class_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':model', $model);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':make_id', $make_id);
    $statement->bindValue(':type_id', $type_id);
    $statement->bindValue(':class_id', $class_id);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}

function delete_vehicle($year, $model, $price, $ids)
{
    global $db;
    $count = 0;
    $query = "DELETE FROM vehicles WHERE year = :year AND model = :model AND price = :price";
    $query_array = get_query_expressions($ids);
    if (count($query_array) > 0) {
        $query .= ' AND ';
        $query .= implode(' AND ', $query_array);
    }
    $query .= ' LIMIT 1';
    $statement = $db->prepare($query);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':model', $model);
    $statement->bindValue(':price', $price);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}
