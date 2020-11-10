<?php

namespace Mateu\Backend\User\Infraestructure\ConsoleCommand;

use Mateu\Backend\User\Application\Create\CreateUserCommand;
use Mateu\Backend\User\Domain\Fullname;
use Mateu\Backend\User\Domain\Username;
use Mateu\Shared\Domain\ValueObject\EmailAddress;
use Mateu\Shared\Infraestructure\ConsoleCommand\ConsoleCommandInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateUserConsoleCommand extends Command implements ConsoleCommandInterface
{
    protected static $defaultName = 'mateu:create:user';

    private $messageBus;

    public function __construct(MessageBusInterface $messageBus, string $name = null)
    {
        parent::__construct($name);

        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new User.')
            ->setHelp('This command allows you to create a new User ...Email, FullName, Username and Password are required options')
            ->addOption('email', null,InputOption::VALUE_REQUIRED, 'User Email')
            ->addOption('fullname', null,InputOption::VALUE_REQUIRED, 'Full Name')
            ->addOption('username', null,InputOption::VALUE_REQUIRED, 'Username')
            ->addOption('password', null,InputOption::VALUE_REQUIRED, 'User Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $email = new EmailAddress($input->getOption('email'));
            $username = new Username($input->getOption('username'));
            $fullname = new Fullname($input->getOption('fullname'));
            $password= $input->getOption('password');

            $this->messageBus->dispatch(
                new CreateUserCommand(
                    $email->get(),
                    $username->value(),
                    $fullname->value(),
                    $password
                )
            );

            $output->writeln('<info>User with email: ' . $email . ' Created!</info>');

        } catch (\Exception $e) {
            $output->writeln('<error>'. $e->getMessage() .'</error>');
            die;
        }
    }

}