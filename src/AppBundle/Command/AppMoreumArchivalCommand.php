<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use AppBundle\Service\PdfService;
use AppBundle\Service\FileService;
use SoapClient;
use SoapHeader;
use SoapFault;
use AppBundle\Entity\Pdf;

class AppMoreumArchivalCommand extends ContainerAwareCommand
{
    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    /** @var EntityManagerInterface */
    private $em;

    /** @var string */
    private $wsdlUrl;

    /** @var PdfService */
    private $pdfService;

    /** @var FileService */
    private $fileService;

    /** @var string */
    private $appName;

    /** @var array */
    private $pdfTypeNames;

    /**
     * @var array
     */
    private $moreumDocTypes;

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('app:moreum:archival')
            ->setDescription('Sends latest unarchived PDF files to Moreum for archival')
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

        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->wsdlUrl = $this->getContainer()->getParameter('moreum_archival_wsdl');
        $this->pdfService = $this->getContainer()->get('AppBundle\Service\PdfService');
        $this->fileService = $this->getContainer()->get('AppBundle\Service\FileService');
        $this->appName = $this->getContainer()->getParameter('app_name');
        $this->pdfTypeNames = $this->getContainer()->getParameter('pdf_type_slugs_map_internal_titles');
        $this->moreumDocTypes = $this->getContainer()->getParameter('pdf_type_slugs_map_moreum_document_types');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output->writeln(sprintf('<info>Started at %s</info>', date('Y-m-d H:i:s')));

        $client = $this->initClient();

        $numArchived = 0;
        $numUnarchived = 0;
        $now = new \DateTime();

        try {
            $pdfs = $this->pdfService->findAllUnarchived('object');
            $numUnarchived = \count($pdfs);

            if (0 < $numUnarchived) {
                foreach ($pdfs as $key => $pdf) {
                    $params = $this->prepareSoapParams($pdf);

                    $response = $client->ArchiveDocument(['request' => $params]);

                    if (0 === $response->ArchiveDocumentResult->ReturnCode) {
                        $numArchived++;

                        $pdf
                            ->setMoreumDocumentId($response->ArchiveDocumentResult->DocumentId)
                            ->setIsArchivalRequired(false)
                            ->setUpdatedAt($now)
                        ;
                        $this->pdfService->savePdfEntity($pdf, false);
                    }
                }

                $this->em->flush();
            }
        } catch (SoapFault $soapFault) {
            $this->output->writeln($soapFault);
            $this->output->writeln($client->__getLastResponse());
        }

        $this->output->writeln(sprintf('<info>Found %d unarchived, successfully archived %d</info>', $numUnarchived, $numArchived));
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
            'http://moreum.com/terradocs/webservices/IArchival/ArchiveDocument'
        );
        $client->__setSoapHeaders($actionHeader);

        return $client;
    }

    /**
     * Returns the pdfTypeName for given Pdf
     * @param Pdf $pdf
     * @return string
     */
    protected function getPdfTypeName(Pdf $pdf)
    {
        return $this->pdfTypeNames[$pdf->getPdfTypeSlug()] ?? '';
    }


    /**
     * Returns SOAP parameters for given Pdf
     * @param $pdf
     * @return array
     */
    protected function prepareSoapParams(Pdf $pdf)
    {
        $dirPath = $this->fileService->getDownloadDir() . '/' . $pdf->getDirName();
        $contents = file_get_contents($dirPath . '/' . $pdf->getFileName());
        //$pdfTypeName = $this->getPdfTypeName($pdf);
        $jsonData = json_decode($pdf->getJsonData());


        $params = [
            '_FileName' => $pdf->getFileName(),
            '_FileContents' => $contents,
            '_DocumentType' => $this->moreumDocTypes[$pdf->getPdfTypeSlug()],
            '_FieldNames' => [
                'POLID',
                'TC Kimlik No',
                'Başvuru No',
                'Poliçe No',
                'Sigortalı',
                'Belge Tipi',
                'Kaydeden Kullanıcı',
            ],
            '_FieldValues' => [
                $pdf->getPolId(),
                $pdf->getPersonalIdNumber(),
                $jsonData->application_number = $jsonData->application_number ?? '',
                $jsonData->policy_number = $jsonData->policy_number ?? '',
                $jsonData->insurer_name = $jsonData->insurer_name ?? '',
                "Diğer",//$pdfTypeName,
                $this->appName,
            ],
        ];

        return $params;
    }
}
