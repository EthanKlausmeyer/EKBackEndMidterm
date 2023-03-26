<?php

class VehicleMake
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
function get_makes()
{
    global $db;
    $query = "SELECT * FROM makes ORDER BY make_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $makes = [];
    foreach ($rows as $row) {
        $make = new VehicleMake($row['make_id'], $row['make_name']);
        $makes[] = $make;
    }

    return $makes;
}

function get_make($make_id)
{
    global $db;
    $query = "SELECT * FROM makes
                        WHERE make_id = :make_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':make_id', $make_id);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    $make = new VehicleMake($row['make_id'] ?? null, $row['make_name'] ?? null);
    return $make;
}
function add_make($make_name)
{
    global $db;
    $count = 0;
    $query = "INSERT INTO makes (make_name)
                        VALUES (:make_name)";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':make_name', $make_name);
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
function delete_make($make_id)
{
    global $db;
    $count = 0;
    $query = "DELETE FROM makes
                        WHERE make_id = :make_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':make_id', $make_id);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}
