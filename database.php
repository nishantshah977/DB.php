<?php

class DatabaseHandler {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function executeStatement($statement, $params = []) {
        try {
            $stmt = $this->conn->prepare($statement);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validateUsername($username) {
        return preg_match('/^[a-zA-Z0-9_]+$/', $username);
    }

    private function validatePhoneNumber($phone) {
        return preg_match('/^(98|97)\d{8}$/', $phone);
    }

    private function sanitizeData($data) {
        return htmlspecialchars($data);
    }

    public function insertData($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->conn->prepare($sql);

            foreach ($data as &$value) {
                $value = $this->sanitizeData($value);
            }

            $stmt->execute(array_values($data));
            return true;
        } catch(PDOException $e) {
            return "Something went wrong while inserting data.";
        }
    }

    public function readData($table, $conditions = "") {
        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        $result = $this->executeStatement($sql);
        if(is_string($result)) return $result; // Return error message if executeStatement returned a string

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateData($table, $data, $conditions) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = ?";
        }
        $set = implode(", ", $set);

        $sql = "UPDATE $table SET $set WHERE $conditions";

        try {
            $stmt = $this->conn->prepare($sql);

            foreach ($data as &$value) {
                $value = $this->sanitizeData($value);
            }

            $stmt->execute(array_values($data));
            return true;
        } catch(PDOException $e) {
            return "Something went wrong while updating data.";
        }
    }

    public function deleteData($table, $conditions) {
        $sql = "DELETE FROM $table WHERE $conditions";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return "Something went wrong while deleting data.";
        }
    }
}

?>
