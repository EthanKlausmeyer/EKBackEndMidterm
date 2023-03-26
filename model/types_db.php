<?php
class VehicleType
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
function get_types()
{
    global $db;
    $query = "SELECT * FROM types ORDER BY type_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $types = [];
    foreach ($rows as $row) {
        $type = new VehicleType($row['type_id'], $row['type_name']);
        $types[] = $type;
    }

    return $types;
}

function get_type($type_id)
{
    global $db;
    $query = "SELECT * FROM types
                        WHERE type_id = :type_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $type_id);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    $type = new VehicleType($row['type_id'] ?? null, $row['type_name'] ?? null);
    return $type;
}

function add_type($type_name)
{
    global $db;
    $count = 0;
    $query = "INSERT INTO types (type_name)
                        VALUES (:type_name)";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':type_name', $type_name);
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
function delete_type($type_id)
{
    global $db;
    $count = 0;
    $query = "DELETE FROM types
                        WHERE type_id = :type_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $type_id);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    }
    $statement->closeCursor();
    return $count;
}
