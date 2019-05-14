<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use AppBundle\Service\FileService;

class AppDataLoadFixturesCommand extends ContainerAwareCommand
{
    const CSV_DIRECTORY = '/src/AppBundle/DataFixtures/csv';
    const FILE_PDF_TEMPLATES_CSV = 'pdf-templates.csv';

    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    /** @var string Current action */
    private $action;

    /** @var array Possible actions */
    private static $actions = [
        'pdf-templates' => 'updatePdfTemplates',
    ];

    /** @var EntityManagerInterface */
    private $em;

    /** @var FileService */
    private $fileService;

    /** @var string Absolute path to directory with CSV files */
    private $csvDirectory;

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('app:data:load-fixtures')
            ->setDescription('Loads data fixtures')
            ->addOption(
                'action',
                null,
                InputOption::VALUE_REQUIRED,
                'Action to perform (e.g. "pdf-templates")',
                null
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \InvalidArgumentException
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->input = $input;
        $this->output = $output;

        $this->action = trim($input->getOption('action'));

        if (!array_key_exists($this->action, self::$actions)) {
            throw new \InvalidArgumentException(sprintf('ERROR: The action "%s" is not valid', $this->action));
        }

        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->fileService = $this->getContainer()->get('AppBundle\Service\FileService');
        $this->csvDirectory = realpath($this->fileService->getProjectRootDir() . self::CSV_DIRECTORY);
    }

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->action = trim($input->getOption('action'));

        if ('' === $this->action) {
            throw new \InvalidArgumentException('ERROR: The parameter --action="..." is required');
        }

        if (!array_key_exists($this->action, self::$actions)) {
            throw new \InvalidArgumentException(sprintf('ERROR: Action "%s" is not valid', $this->action));
        }

        $funcName = self::$actions[$this->action];

        if (!\is_callable(array($this, $funcName))) {
            throw new \InvalidArgumentException(sprintf('ERROR: Action "%s" is not valid', $this->action));
        }

        $this->$funcName();
    }

    /**
     * Updates/Inserts PdfTemplate entities from CSV file
     *
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    protected function updatePdfTemplates()
    {
        // TODO: remove exception after implementing method
        throw new \Symfony\Component\Intl\Exception\MethodNotImplementedException(__CLASS__ . ':' . __METHOD__);

        $this->output->writeln(sprintf('<info>Started action "%s" at %s</info>', __FUNCTION__, date('Y-m-d H:i:s')));

        $filePath = $this->csvDirectory . '/' . self::FILE_PDF_TEMPLATES_CSV;

        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException(sprintf('ERROR: The file "%s" does not exist', $filePath));
        }

        if (!is_file($filePath)) {
            throw new \InvalidArgumentException(sprintf('ERROR: The file "%s" is not a valid file', $filePath));
        }

        $csvRows = $this->fileService->loadArrayFromCsv($filePath);
        $rows = [];
        foreach ($csvRows as $csvRow) {
            $rows[$csvRow['slug']] = $csvRow;
        }

        $outputResults = [];

        // TODO: handle update/insert here

        $table = new Table($this->output);
        $table
            ->setHeaders(['slug', 'title', 'type', 'file', 'status'])
            ->setRows($outputResults)
        ;

        $table->render();

        $this->output->writeln(sprintf('<info>Finished action "%s" at %s</info>', __FUNCTION__, date('Y-m-d H:i:s')));
    }
}
