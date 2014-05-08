<?php
/**
 * User: PGamach1
 * Date: 2014-05-08
 * Time: 1:05 PM
 *
 */

namespace Phil\GeolocationBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class exportLocationCommand extends ContainerAwareCommand {
    protected function configure()
    {

        $this
            ->setName('geolocation:export:javascript')
            ->setDescription('Export User Location Choices.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progress = $this->getHelperSet()->get('progress');
        $em   = $this->getContainer()->get('doctrine')->getEntityManager();

        $em->createQuery('SELECT Year(current_date()) FROM TestBundle:Product p');

        $progress->start($output, 50);
        $i = 0;
        while ($i++ < 50) {
            // ... do some work

            // advance the progress bar 1 unit
            $progress->advance();
        }

        $progress->finish();

        $output->writeln('DONE');
    }

}