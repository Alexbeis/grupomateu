<?php

namespace Mateu\Backend\User\Application\Create;

class CreateUserCommand
{
    private $email;
    private $username;
    private $fullname;
    private $password;

    public function __construct($email, $username, $fullname, $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}