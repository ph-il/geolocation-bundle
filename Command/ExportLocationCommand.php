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

/**
 * Class ExportLocationCommand
 *
 * This need to be more generic.
 *
 * @package Phil\GeolocationBundle\Command
 */
class ExportLocationCommand extends ContainerAwareCommand {

    protected function configure()
    {

        $this
            ->setName('geolocation:export:javascript')
            ->setDescription('Export User Location Choices.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progress = $this->getHelperSet()->get('progress');

        $conn = $this->getContainer()->get('doctrine.dbal.default_connection');

        $kernel = $this->getContainer()->get('kernel');

        $sqlTop10  = 'SELECT distinct *
              FROM geo_locality
              WHERE sub_region = "Top10";';

        $sqlTop100  = 'SELECT distinct *
              FROM geo_locality;';

        $output->writeln('Exporting English' );

        $output->writeln('Exporting Top 10' );
        $top10 = $this->exportData($output, $conn, $sqlTop10, $progress);

        $output->writeln('Exporting Top 100' );
        $top100 = $this->exportData($output, $conn, $sqlTop100, $progress);


        $values = array(
            array(
                'id' => 'geolocation_top10',
                'title' => 'Top 10 Cities',
                'datas' => $top10
            ),
            array(
                'id' => 'geolocation_top100',
                'title' => 'Top 100 Cities',
                'datas' => $top100
            )
        );

        @file_put_contents($kernel->locateResource('@PhilGeolocationBundle/Resources/public/js') . '/locality_en.js', 'var geolocationLocality = ' . json_encode($values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . ';' );

        $output->writeln('Exporting French' );

        $values = array(
            array(
                'id' => 'geolocation_top10',
                'title' => '10 villes les plus recherchées',
                'datas' => $top10
            ),
            array(
                'id' => 'geolocation_top100',
                'title' => '100 villes les plus recherchées',
                'datas' => $top100
            )
        );

        @file_put_contents($kernel->locateResource('@PhilGeolocationBundle/Resources/public/') . 'js/locality_fr.js', 'var geolocationLocality = ' . json_encode($values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . ';' );

        $output->writeln('DONE');
    }

    /**
     * @param OutputInterface $output
     * @param Connection      $conn
     * @param string          $sql
     * @param Progress        $progress
     *
     * @return array
     */
    private function exportData(OutputInterface $output, $conn, $sql, $progress)
    {
        $values = array();
        $rows   = $conn->fetchAll($sql);

        $progress->start($output, count($rows));

        foreach ($rows as $row) {
            $data = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $row['latitude_longitude']);
            $values[] = array('name' => $row['name'], 'lat' => $data['lat'], 'lon' => $data['lon']);
            $progress->advance();
        }

        $progress->finish();

        return $values;
    }

}