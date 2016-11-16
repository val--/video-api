<?php
namespace VideoBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
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
/*        $output->writeln([
        '=============================',
        '[* *]   Video Creator   [* *]',
        '=============================',
        '',
	    ]);*/

        $output->writeln([
        '.------------------------.',         
        '|\\//////  Video Creator  |',      
        '| \/  __  ______  __     |',             
        '|    /  \|\.....|/  \    |',             
        '|    \__/|/_____|\__/    |',             
        '| A                      |',             
        '|    ________________    |',             
        '|___/_._o________o_._\___|',
        '',
        ]);
/*
        $date = "2016-10-10 12:10:45";
        $title = "Video";
        $realisator = "Director";
*/

        $videoFactory = $this->getContainer()->get('video.factory');
/*        $helper = $this->getHelper('question');*/

/*        $question_title = new Question('Please enter the name of the video : ', 'Video');
        $question_title->setValidator(function ($answer) {
        if (strlen($answer) > 39){
            throw new \RuntimeException('The name of the video must be less than 40 characters.');
        }
        else if(strlen($answer) < 3){
            throw new \RuntimeException('The name of the video must be more than 2 characters.');
        }
        return $answer;
        });
        $question_title->setMaxAttempts(20);
        $title = $helper->ask($input, $output, $question_title);


        $question_date = new Question('Please enter the date (datetime format, ex. "2016-10-10 12:10:45") of the video : ', '2016-10-10 12:10:45');
        $date = $helper->ask($input, $output, $question_date);


        $question_realisator = new Question('Please enter the director of the video : ', 'Director');
        $realisator  = $helper->ask($input, $output, $question_realisator);
*/  

        $title = $input->getArgument('title');
        $date = $input->getArgument('date');
        $realisator = $input->getArgument('realisator');

        $pattern = "(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})";
        if(preg_match($pattern, $date)){
            $date = new \DateTime($input->getArgument('date'));
        }else{
            throw new \RuntimeException('Wrong date format for this video (datetime expected)');   
        }

        $videoFactory->createVideo($title, $date, $realisator);
        $output->writeln('Video "'.$title.'" successfully created!');
	}
}