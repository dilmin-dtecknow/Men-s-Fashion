<?php
class Database{

    public static $connection;

    public static function setupConnection(){
        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "root", "dna%2002#fJk", "web1_online_shop", "3306");
        }
    }

    public static function iud($query){
        Database::setupConnection();
        Database::$connection->query($query);
        // Return the last inserted ID if an INSERT query was executed
        return Database::$connection->insert_id;
    }

    public static function search($query){
        Database::setupConnection();
        $resultest = Database::$connection->query($query);
        return $resultest;
    }

    // Search with prepared statements
    public static function searchPrepared($query, $params, $types) {
        Database::setupConnection();
        $stmt = Database::$connection->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . Database::$connection->error);
        }
        // Bind the parameters dynamically
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }
}
