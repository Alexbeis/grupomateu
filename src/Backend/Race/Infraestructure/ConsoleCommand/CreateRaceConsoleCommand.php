<?php

namespace Mateu\Backend\Race\Infraestructure\ConsoleCommand;

use Mateu\Backend\Race\Domain\RaceCode;
use Mateu\Backend\Race\Domain\RaceName;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use Mateu\Shared\Infraestructure\ConsoleCommand\ConsoleCommandInterface;
use Mateu\Backend\Race\Application\Create\CreateRaceCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateRaceConsoleCommand extends Command implements ConsoleCommandInterface
{
    protected static $defaultName = 'mateu:create-race';

    private $messageBus;

    public function __construct(MessageBusInterface $messageBus, string $name = null)
    {
        parent::__construct($name);

        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new Race.')
            ->setHelp('This command allows you to create a new Race ...Code and Name are required options')
            ->addOption('code', null,InputOption::VALUE_REQUIRED, 'Code of the Race')
            ->addOption('name', null,InputOption::VALUE_REQUIRED, 'Name of the Race');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Race Creator',
            '============',
            '',
        ]);

        try {
            $code = (new RaceCode($input->getOption('code')))->getCode();
            $name = (new RaceName($input->getOption('name')))->getName();

            $output->writeln('Race Code: '.$code);
            $output->writeln('Race Name: '.$name);

            $this->messageBus->dispatch(
                new CreateRaceCommand(
                    Uuid::random()->getValue(),
                    $code,
                    $name
                )
            );

            $output->writeln('<info>Race : ' . $name . '('. $code . '), Created!</info>');

        } catch (\Exception $e) {
            $output->writeln('<error>'. $e->getMessage() .'</error>');
            die;
        }
    }
}