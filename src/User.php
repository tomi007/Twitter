<?php

class User
{
    private $id;
    private $username;
    private $hashPassword;
    private $email;

    public function __construct()
    {
        $this->id = -1;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getHashPassword()
    {
        return $this->hashPassword;
    }

    public function setHashPassword($hashPassword)
    {
        $this->hashPassword = $hashPassword;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function save(PDO $pdo)
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO Users(username, email, hash_password) VALUES (:username, :email, :hashPassword)";

            $prepare = $pdo->prepare($sql);
            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(
                [
                    'username'     => $this->username,
                    'email'        => $this->email,
                    'hashPassword' => $this->hashPassword,
                ]
            );

            // Pobranie ostatniego ID dodanego rekordu
            $this->id = $pdo->lastInsertId();

            return (bool)$result;
        } else {

        }

    }
}
