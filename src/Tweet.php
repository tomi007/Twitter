<?php
/**
 * Klasa Tweet
 */
class Tweet
{
    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
    }

    static public function loadTweetById(PDO $connection, $id)
    {
        $stmt = $connection->prepare('SELECT * FROM Tweets WHERE id=:id');
        $result = $stmt->execute(['id'=> $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];
            return $loadedTweet;
        }

        return null;
    }

    static public function loadAllTweetsByUserId(PDO $connection, $userId)
    {
      // nasze zapytanie sql
      $stmt = $connection->prepare('SELECT * FROM Tweets WHERE userId=:userId ORDER BY `creationDate` DESC');
      $result = $stmt->execute(['userId'=> $userId]);

      $ret = []; // pusta tablica w której przechowamy wyniki zapytania

      if ($result === true && $stmt->rowCount() > 0) {

          foreach ($stmt as $row) {
              $loadedTweet = new Tweet();
              $loadedTweet->id = $row['id'];
              $loadedTweet->userId = $row['userId'];
              $loadedTweet->text = $row['text'];
              $loadedTweet->creationDate = $row['creationDate'];
              // przypisujemy nasz obiekt do tablicy
              $ret[] = $loadedTweet;
          }
          return $ret;
      }
      return null;
    }

    static public function loadAllTweets(PDO $connection)
    {
      // nasze zapytanie sql

      $result = $connection->query("SELECT * FROM Tweets ORDER BY `creationDate` DESC");
      $ret = []; // pusta tablica w której przechowamy wyniki zapytania

      if ($result->rowCount() > 0) {
          foreach ($result as $row) {
              //$row = $result->fetch(PDO::FETCH_ASSOC);
              $loadedTweet = new Tweet();
              $loadedTweet->id = $row['id'];
              $loadedTweet->userId = $row['userId'];
              $loadedTweet->text = $row['text'];
              $loadedTweet->creationDate = $row['creationDate'];
              // przypisujemy nasz obiekt do tablicy
              $ret[] = $loadedTweet;
          }
          return $ret;
      }
      return null;
    }

    public function save(PDO $pdo)
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO Tweets(userId, text) VALUES (:userId, :text)";

            $prepare = $pdo->prepare($sql);
            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(
                [
                    'userId'     => $this->userId,
                    'text'        => $this->text,
                ]
            );

            // Pobranie ostatniego ID dodanego rekordu
            $this->id = $pdo->lastInsertId();
            return (bool)$result;
        } else {

        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

}
