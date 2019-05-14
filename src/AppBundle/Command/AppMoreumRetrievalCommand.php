<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Service\PdfService;
use AppBundle\Service\FileService;
use SoapClient;
use SoapHeader;

class AppMoreumRetrievalCommand extends ContainerAwareCommand
{
    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    /** @var string */
    private $wsdlUrl;

    /** @var FileService */
    private $fileService;

    /** @var array */
    private $pdfTypeNames;

    /** @var string */
    private $moreumDocumentId;

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('app:moreum:retrieval')
            ->setDescription('Retrieves archived PDF files from Moreum')
            ->addArgument(
                'moreumDocumentId',
                InputArgument::REQUIRED,
                'Moreum document ID to retrieve',
                null
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->input = $input;
        $this->output = $output;
        $this->moreumDocumentId = trim($input->getArgument('moreumDocumentId'));

        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->wsdlUrl = $this->getContainer()->getParameter('moreum_retrieval_wsdl');
        $this->fileService = $this->getContainer()->get('AppBundle\Service\FileService');
        $this->pdfTypeNames = $this->getContainer()->getParameter('pdf_type_slugs_map_internal_titles');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output->writeln(sprintf('<info>Started at %s</info>', date('Y-m-d H:i:s')));

        $client = $this->initClient();

        $params = $this->prepareSoapParams($this->moreumDocumentId);

        $response = $client->GetDocumentInfo(['downloadRequest' => $params]);
        $fileContent = $response->GetDocumentInfoResult->Files->FileInfo->Content;
        $fileName = $response->GetDocumentInfoResult->Files->FileInfo->Name;

        $dirPath = $this->fileService->getDownloadDir();
        file_put_contents($dirPath . '/' . $fileName, $fileContent);

        $this->output->writeln(sprintf('<info>File saved as %s</info>', $dirPath . '/' . $fileName));
        $this->output->writeln(sprintf('<info>Finished at %s</info>', date('Y-m-d H:i:s')));
    }

    /**
     * Initializes and returns the SoapClient
     * @return SoapClient
     */
    protected function initClient()
    {
        $client = new SoapClient(
            $this->wsdlUrl,
            [
                'soap_version' => SOAP_1_2,
                'trace' => true,
                'exceptions' => true
            ]
        );

        $actionHeader = new SoapHeader(
            'http://www.w3.org/2005/08/addressing',
            'Action',
            'http://moreum.com/terradocs/webservices/IRetrieval/GetDocumentInfo'
        );
        $client->__setSoapHeaders($actionHeader);

        return $client;
    }

    /**
     * Returns SOAP parameters for given $moreumDocumentId
     * @param $moreumDocumentId
     * @return array
     */
    protected function prepareSoapParams($moreumDocumentId)
    {
        $params = [
            'ID' => $moreumDocumentId,
            'IncludeContents' => 1,
            'FileGUIDs' => []
        ];

        return $params;
    }
}
