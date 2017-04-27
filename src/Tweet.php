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
      $stmt = $connection->prepare('SELECT * FROM Tweets WHERE userId=:userId ORDER BY `creationDate` DESC');
      $result = $stmt->execute(['userId'=> $userId]);

      $ret = []; // pusta tablica

      //print_r($stmt->rowCount());
      if ($result === true && $stmt->rowCount() > 0) {

          foreach ($stmt as $row) {
              $loadedTweet = new Tweet();
              $loadedTweet->id = $row['id'];
              $loadedTweet->userId = $row['userId'];
              $loadedTweet->text = $row['text'];
              $loadedTweet->creationDate = $row['creationDate'];
              $ret[] = $loadedTweet;
              //echo "<b>[" . $row['creationDate'] . "]</b> " . $row['text'] . '<br>';
          }
          return $ret;
          //
          // $row = $stmt->fetch(PDO::FETCH_ASSOC);
          // $loadedTweet = new Tweet();
          // $loadedTweet->id = $row['id'];
          // $loadedTweet->userId = $row['userId'];
          // $loadedTweet->text = $row['text'];
          // $loadedTweet->creationDate = $row['creationDate'];
          // return $loadedTweet;
      }
      return null;
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
