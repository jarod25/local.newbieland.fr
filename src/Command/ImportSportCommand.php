<?php

namespace App\Command;

use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-sport',
    description: 'Add a short description for your command',
)]
class ImportSportCommand extends Command
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('CSV File', InputArgument::REQUIRED, 'CSV File');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importing CSV file...');

        $csv = array_map('str_getcsv', file($input->getArgument('CSV File')));
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

        foreach ($csv as $row) {
            $sport = new Sport();
            $sport->setNom($row['nom']);
            $sport->setDescription($row['description']);
            $this->entityManager->persist($sport);
        }

        $this->entityManager->flush();
        $io->success('Command exited cleanly!');

        return Command::SUCCESS;
    }
}
