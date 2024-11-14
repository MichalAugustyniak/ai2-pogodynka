<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-city',
    description: 'Returns a list of weather measurements for the given country code and city name.',
)]
class WeatherCountryCityCommand extends Command
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('arg2', InputArgument::REQUIRED, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $country = $input->getArgument('arg2');
        $city = $input->getArgument('arg1');

        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
        $io->writeln(sprintf('Location: %s', $city));
        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\t%s: \n\t\tmin: %s\n\t\tmax: %s",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getMinCelsius(),
                $measurement->getMaxCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}
