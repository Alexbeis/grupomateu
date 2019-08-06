<?php


namespace Mateu\Backend\Notification\Application\Create;


class NotificationCommand
{
    private $message;
    private $user;

    public function __construct($message, array $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}