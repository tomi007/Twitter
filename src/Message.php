<?php
/**
* klasa Message
*/
class Message
{
    private $id;
    private $sender; //nadawca
    private $recipient; //odbiorca
    private $message;
    private $creationDate;

    function __construct()
    {
      $this->id = -1;
    }

    static public function loadAllSendMessagesByUserId(PDO $connection, $sender)
    {
        $stmt = $connection->prepare('SELECT * FROM Messages WHERE sender=:sender');
        $result = $stmt->execute(['sender'=> $sender]);

        $ret = []; // pusta tablica w której przechowamy wyniki zapytania
        if ($result === true && $stmt->rowCount() > 0){
            foreach ($stmt as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->sender = $row['sender'];
                $loadedMessage->recipient = $row['recipient'];
                $loadedMessage->message = $row['message'];
                $loadedMessage->creationDate = $row['creationDate'];
                $ret[] = $loadedMessage;
            }
            return $ret;
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

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
