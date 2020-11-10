<?php

namespace Mateu\Backend\User\Application\Create;

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
        $this->userCreator->create(
            $createUserCommand->getEmail(),
            $createUserCommand->getUsername(),
            $createUserCommand->getFullname(),
            $createUserCommand->getPassword()
        );
    }
}