<?php

require_once("constants.php");

class Database {


        private $conn;

        public function __construct($configFile = "config.ini") {
            try {
                if ($config = parse_ini_file($configFile, true)) {

                    $host = $config["database"]["host"];
                    $dbname = $config["database"]["database"];
                    $user = $config["database"]["user"];
                    $password = $config["database"]["password"];

                    $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } else {
                    throw new Exception("Missing configuration file.");
                }
            } catch (PDOException $e) {
                die("PDO greška: " . $e->getMessage());
            } catch (Exception $e) {
                die("Greška: " . $e->getMessage());
            }
        }

        
        public function __destruct() {
	    	$this->conn = null;
	    }


        public function getConnection() {
            return $this->conn;
        }

        public function insertVezbe($username, $email, $password, $role) {
            $sql = "INSERT INTO ".TBL_USERS." (".COL_USERNAME.", ".COL_EMAIL.", ".COL_PASSWORD.", ".COL_ROLE.") 
                    VALUES (:username, :email, :password, :role)";
            
            try {
                $st = $this->conn->prepare($sql);

                $st->bindValue(":username", $username);
                $st->bindValue(":email", $email);
                $st->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
                $st->bindValue(":role", $role);
                $st->execute();
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
                return false;
            }
            return true;
        }

        public function setRememberToken($userId, $token) {
            $sql = "UPDATE ".TBL_USERS." SET ".COL_REMEMBER_TOKEN." = :token WHERE id = :id";
            $st = $this->conn->prepare($sql);
            $st->bindValue(":token", password_hash($token, PASSWORD_DEFAULT));
            $st->bindValue(":id", $userId);
            $st->execute();
        }

        public function clearRememberToken($userId) {
            $sql = "UPDATE ".TBL_USERS." SET ".COL_REMEMBER_TOKEN." = NULL WHERE id = :id";
            $st = $this->conn->prepare($sql);
            $st->bindValue(":id", $userId);
            $st->execute();
        }

        public function getUserByRememberToken($userId, $token) {
            $sql = "SELECT * FROM ".TBL_USERS." WHERE id = :id AND ".COL_REMEMBER_TOKEN." IS NOT NULL";
            $st = $this->conn->prepare($sql);
            $st->bindValue(":id", $userId);
            $st->execute();
            $user = $st->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($token, $user[COL_REMEMBER_TOKEN])) {
                return $user;
            }
            return false;
        }

        public function getAllGames() {
            $sql = "SELECT * FROM Games ORDER BY created_at DESC";
            $st = $this->conn->prepare($sql);
            $st->execute();
            return $st->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getGameById($id) {
            $sql = "SELECT * FROM Games WHERE id = :id LIMIT 1";
            $st = $this->conn->prepare($sql);
            $st->bindValue(':id', $id, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch(PDO::FETCH_ASSOC);
        }

        public function getGameBySlug($slug) {
            $sql = "SELECT * FROM Games WHERE slug = :slug LIMIT 1";
            $st = $this->conn->prepare($sql);
            $st->bindValue(':slug', $slug, PDO::PARAM_STR);
            $st->execute();
            return $st->fetch(PDO::FETCH_ASSOC);
        }

}