<?php

namespace Models;

use Models\Database;


class Model
{

    protected $table;
    private $conn;

    public function __construct()
    {
        $database = new Database;
        $this->conn = $database->getConn();

        $className = strtolower((new \ReflectionClass($this))->getShortName());
        $this->table = str_replace('models', '', $className);
        $this->table = (substr($this->table, -1) === 'y') ? substr($this->table, 0, -1) . 'ies' : $this->table . 's';
    }


    /**
     * Returns all the records from the database table
     *
     * @return array
     */
    public function all()
    {

        $sql = "SELECT * FROM $this->table";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $th) {
            throw $th;
        }
    }

    /**
     * Find a record in the database based on the given ID
     *
     * @param int $id The ID of the record to find
     * @return array|bool The record data if found, or false if not found
     */
    public function find(int $id): array|bool
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $th) {
            throw $th;
        }
    }

    /**
     * Creates a new record in the database table
     *
     * @param array $data The data to insert into the record
     * @return array The created record data
     */
    public function create(array $data): array
    {

        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO `$this->table` ($fields) values ($placeholders)";

        try {
            $stmt = $this->conn->prepare($sql);

            foreach ($data as $field => $value) {
                $stmt->bindValue(":$field", $value);
            }

            $stmt->execute();

            return $this->find($this->conn->lastInsertId());
        } catch (\PDOException $th) {
            throw $th;
        }
    }

    /**
     * Updates a record in the database table based on the given ID
     *
     * @param int $id The ID of the record to update
     * @param array $data The data to update the record with
     * @return array The updated record data
     */
    public function update(int $id, array $data): array
    {
        $sql = "UPDATE `$this->table` SET ";

        $setFields = [];
        foreach ($data as $field => $value) {
            $setFields[] = "`$field` = :$field";
        }

        $sql .= implode(", ", $setFields);
        $sql .= " WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($sql);

            foreach ($data as $field => $value) {
                $stmt->bindValue(":$field", $value);
            }
            $stmt->bindValue(":id", $id);

            $stmt->execute();

            return $this->find($id);
        } catch (\PDOException $th) {
            throw $th;
        }
    }

    /**
     * Deletes a record from the database table based on the given ID
     *
     * @param int $id The ID of the record to delete
     * @return bool Returns true if the record was deleted, or false if not found
     */
    public function delete($id)
    {
        $sql = "DELETE FROM $this->table Where id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (\PDOException $th) {
            throw $th;
        }
    }

    /**
     * Find a record in the database based on the given field and value
     *
     * @param string $field The field to search
     * @param mixed $value The value to search for
     * @return array|bool The record data if found, or false if not found
     */
    public function where(string $field, $value): array|bool
    {
        $sql = "SELECT * FROM $this->table WHERE $field = :$field";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":$field", $value);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $th) {
            throw $th;
        }
    }
 
}
