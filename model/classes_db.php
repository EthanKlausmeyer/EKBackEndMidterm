<?php

class VehicleClass
{
    private $id, $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setID($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
function get_classes()
{
    global $db;
    $query = "SELECT * FROM classes ORDER BY class_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $classes = [];
    foreach ($rows as $row) {
        $class = new VehicleClass($row['class_id'], $row['class_name']);
        $classes[] = $class;
    }

    return $classes;
}
function getClass($class_id)
{
    global $db;
    $query = "SELECT * FROM classes
                        WHERE class_id = :class_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    $class = new VehicleClass($row['class_id'] ?? null, $row['class_name'] ?? null);
    return $class;
}

function add_class($class_name)
{
    global $db;
    $count = 0;
    $query = "INSERT INTO classes (class_name)
                        VALUES (:class_name)";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':class_name', $class_name);
        if ($statement->execute()) {
            $count = $statement->rowCount();
        }
    } catch (PDOException $e) {
        $count = 0;
    } finally {
        $statement->closeCursor();
    }
    return $count;
}
function delete_class($class_id)
{
    global $db;
    $count = 0;
    $query = "DELETE FROM classes
                        WHERE class_id = :class_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}
