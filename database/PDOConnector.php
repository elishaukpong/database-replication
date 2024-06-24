<?php

class PDOConnector
{
    private string $host;
    private string $username;
    private string $password;
    private string $database;

    public function setHostName(string $host)
    {
        $this->host = $host;

        return $this;
    }

    public function setUserName(string $username)
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function setDBName(string $database)
    {
        $this->database = $database;

        return $this;
    }

    public function connect(array $options = [])
    {
        try {
            return new PDO(
                "mysql:host=$this->host;dbname=$this->database",
                $this->username,
                $this->password,
                $options
            );
        } catch(PDOException $e) {
            echo "Error!:". $e->getMessage() . "<br/>";
            die();
        }
    }
}