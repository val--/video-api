<?php
namespace VideoBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class AddVideoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('video:add-video')

        // the short description shown while running "php bin/console list"
        ->setDescription('Creates new videos.')

        ->addArgument('title', InputArgument::REQUIRED, 'The video title.')
        ->addArgument('date', InputArgument::REQUIRED, 'Video added date.')
        ->addArgument('realisator', InputArgument::REQUIRED, 'The video director.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("This command allows you to create videos.")
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
        'Video Creator',
        '============',
        '',
	    ]);
        $videoFactory = $this->getContainer()->get('video.factory');
        $videoFactory->createVideo($input->getArgument('title'),new \DateTime($input->getArgument('date')),$input->getArgument('realisator'));

        $output->writeln('Video successfully created!');
	    // retrieve the argument value using getArgument()
	    //$output->writeln('Video title: '.$input->getArgument('title'));
	}
}