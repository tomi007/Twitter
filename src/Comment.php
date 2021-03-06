<?php
/**
 * Klasa Comment
 */
class Comment
{

    private $id;
    private $userId;
    private $tweetId;
    private $comment;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
    }

    static public function loadAllCommentByTweetId(PDO $connection, $tweetId)
    {
      $stmt = $connection->prepare('SELECT * FROM Comments WHERE tweetId=:tweetId ORDER BY creationDate DESC');
      $result = $stmt->execute(['tweetId'=> $tweetId]);

      $ret = []; // pusta tablica w której przechowamy wyniki zapytania

      if ($result === true && $stmt->rowCount() > 0) {

        foreach ($stmt as $row) {
          $loadedComment = new Comment();
          $loadedComment->id = $row['id'];
          $loadedComment->userId = $row['userId'];
          $loadedComment->tweetId = $row['tweetId'];
          $loadedComment->comment = $row['comment'];
          $loadedComment->creationDate = $row['creationDate'];
          // przypisujemy nasz obiekt do tablicy
          $ret[] = $loadedComment;
        }
        return $ret;
      }
      return null;
    }

    public function save(PDO $pdo)
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO Comments(userId, tweetId, comment) VALUES (:userId, :tweetId, :comment)";

            $prepare = $pdo->prepare($sql);
            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(
                [
                    'userId'  => $this->userId,
                    'tweetId' => $this->tweetId,
                    'comment' => $this->comment
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

    public function getTweetId()
    {
        return $this->tweetId;
    }

    public function setTweetId($tweetId)
    {
        $this->tweetId = $tweetId;

        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;

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
