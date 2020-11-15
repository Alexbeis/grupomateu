<?php

namespace Mateu\Backend\User\Application\Create;

use Assert\Assert;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateUserCommandHandler implements MessageHandlerInterface
{
    /**
     * @var UserCreator
     */
    private $userCreator;

    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    public function __invoke(CreateUserCommand $createUserCommand)
    {
        $email = $createUserCommand->getEmail();
        $username = $createUserCommand->getUsername();
        $fullname = $createUserCommand->getFullname();
        $password = $createUserCommand->getPassword();

        Assert::lazy()
            ->that($email, 'email')
            ->notEmpty()
            ->email()
            ->that($username, 'UserName')
            ->notEmpty()
            ->string()
            ->betweenLength(2, 50)
            ->that($fullname, 'Fullname')
            ->notEmpty()
            ->string()
            ->betweenLength(2, 50)
            ->that($password, 'Contraseña')
            ->notEmpty()
            ->string()
            ->verifyNow();

        $this->userCreator->create(
            $email,
            $createUserCommand->getUsername(),
            $createUserCommand->getFullname(),
            $createUserCommand->getPassword()
        );
    }
}