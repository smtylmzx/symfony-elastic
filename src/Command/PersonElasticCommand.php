<?php


namespace App\Command;


use App\Service\ElasticService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class PersonElasticCommand
 * @package App\Command
 */
class PersonElasticCommand extends Command
{
    private const COMMAND_NAME = 'elastic:populate:person';

    /**
     * @var ElasticService
     */
    private $elasticPopulateService;

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Elastic populate command for person.');
    }

    /**
     * PersonElasticCommand constructor.
     * @param ElasticService $elasticPopulateService
     */
    public function __construct(ElasticService $elasticPopulateService)
    {
        $this->elasticPopulateService = $elasticPopulateService;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $io->info('Elastic populate started.');

            $this->elasticPopulateService->populate();

            $io->success('Elastic populate completed.');
        } catch (\Exception $exception) {
            $io->error(
                sprintf('Elastic populate failed. Message: %s',
                    $exception->getMessage()
                )
            );

            return -1;
        }

        return 1;
    }
}
