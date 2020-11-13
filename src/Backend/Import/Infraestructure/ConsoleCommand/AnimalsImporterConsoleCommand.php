<?php

namespace Mateu\Backend\Import\Infraestructure\ConsoleCommand;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Mateu\Backend\Explotation\Infraestructure\ExplotationRepository;
use Mateu\Shared\Infraestructure\ConsoleCommand\ConsoleCommandInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Messenger\MessageBus;

class AnimalsImporterConsoleCommand  extends Command implements ConsoleCommandInterface
{
    protected static $defaultName = 'mateu:import:animals';

    private $csvParsingOptions = array(
        'finder_in' => 'src/Resources/',
        'ignoreFirstLine' => true
    );
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ExplotationRepositoryInterface $explotationRepository,
        string $name = null
    ) {
        parent::__construct($name);

        $this->entityManager = $entityManager;
        $this->explotationRepository = $explotationRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Import animals from csv')
            ->setHelp('This command allows you to Import animals from csv to given explotation')
            ->addOption('filename', null,InputOption::VALUE_REQUIRED, 'File Name')
            ->addOption('explotation', null,InputOption::VALUE_REQUIRED, 'Explotation Code');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getOption('filename');
        $explotation = $input->getOption('explotation');

        if (!$filename || ! $explotation) {
            $output->writeln('<error> Please add filename (in /src/Resources) and Explotation Code</error>');
            return;
        }
        $csvIterator = $this->parseCsv($filename);

        /*foreach ($csvIterator as $line) {
            // TODO: Create animal entity and assign to  explotation
        }*/

    }

    private function parseCsv($filename)
    {
        $ignoreFirstLine = $this->csvParsingOptions['ignoreFirstLine'];

        $finder = new Finder();
        $finder->files()
            ->in($this->csvParsingOptions['finder_in'])
            ->name($filename);

        foreach ($finder as $file) { $csv = $file; }

        if (($handle = fopen($csv->getRealPath(), "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, null, ";")) !== FALSE) {
                $i++;
                if ($ignoreFirstLine && $i == 1) { continue; }
                //$rows[] = $data;
                yield $data;
            }
            fclose($handle);
        }
    }
}
