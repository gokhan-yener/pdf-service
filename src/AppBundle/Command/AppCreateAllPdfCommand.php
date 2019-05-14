<?php

namespace AppBundle\Command;


use AppBundle\Service\FileService;
use AppBundle\Service\PdfFileService;
use AppBundle\Service\PdfService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Pdf;
use Symfony\Component\Console\Input\InputArgument;

class AppCreateAllPdfCommand extends ContainerAwareCommand
{

    /** @var PdfService */
    private $pdfService;

    /** @var PdfFileService */
    private $pdfFileService;

    /** @var FileService */
    private $fileService;

    /** @var EntityManagerInterface\ */
    private $em;

    /** @var string */
    private $downloadFile;

    /** @var Jmserializer */
    private $serializer;



    protected function configure()
    {
        $this
            ->setName('app:pdf-regenerate')
            ->setDescription('Creates all Pdf in the database that are not in the download folder')
            ->addArgument(
                'personal_id',
                InputArgument::IS_ARRAY
            )
            // ...
        ;
    }


    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->input = $input;
        $this->output = $output;

        $doctrine = $this->getContainer()->get('doctrine');
        $this->em = $doctrine->getEntityManager();
        $this->downloadFile = $this->getContainer()->getParameter('web_download_dir');
        $this->pdfFileService = $this->getContainer()->get('AppBundle\Service\PdfFileService');
        $this->fileService = $this->getContainer()->get('AppBundle\Service\FileService');
        $this->pdfService = $this->getContainer()->get('AppBundle\Service\PdfService');
        $this->serializer = $this->getContainer()->get('jms_serializer');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

      $output->writeln([
            'Pdf Generator',
            '============',
            '',
        ]);
         $personalId = $input->getArgument('personal_id');
 /*       foreach ($personalId as $item){
            $output->writeln('Username: '.$item);
        }*/
        $this->reGenerateAllPdf($personalId);

    }

    public function reGenerateAllPdf($personalIds)
    {

     //   $allPdfRecord = $this->em->getRepository('AppBundle:PdfLog')->findAll();
        $pdfRecord = $this->em->getRepository('AppBundle:PdfLog')->getRetrievePdf($personalIds);

        if(count($pdfRecord) > 0){
            foreach ($pdfRecord as $pdf) {

                $result = $this->isPdfFile($pdf->getDirName(), $pdf->getFileName());

                if (!$result) {

                    $this->output->writeln(sprintf("pdf is regenerating ...id:%s, filename: %s, folder: %s ",$pdf->getId(),$pdf->getFileName(),$pdf->getDirName()));
                    $this->createPdfFile($pdf);
                    $this->output->writeln(sprintf("pdf regenerated ...id:%s, filename: %s, folder: %s ",$pdf->getId(),$pdf->getFileName(),$pdf->getDirName()));

                }else{
                    $this->output->writeln(sprintf("Pdf already exists in Pdf folder"));
                }

            }
        }else{
            $this->output->writeln(sprintf("was not personel_id in database "));

        }


    }

    public function createPdfFile($getPdfData)
    {

        $pdfModelName = $this->pdfModelName($getPdfData->getPdfTypeSlug());
        $model = $this->serializer->deserialize($getPdfData->getJsonData(), $pdfModelName, 'json');
        $decoratorName = $this->pdfDecoratorName($getPdfData->getPdfTypeSlug());

        $decorator = new $decoratorName(
            $model,
            $this->fileService,
            $this->getContainer()->get('twig'),
            $this->getContainer()->getParameter('project_pdf_template_dir'),
            $this->getContainer()->getParameter('project_pdf_images_dir'),
            $this->getContainer()->getParameter('web_pdf_images_dir'),
            $this->getContainer()->getParameter('insurance_slugs'),
            $this->getContainer()->getParameter('pdf_type_slugs_map_internal_titles')
        );

        $pdfData = $decorator->getDecoratedData();

        $pdf = new Pdf();
        $now = new \DateTime();
        $pdf
            ->setPersonalIdNumber($getPdfData->getPersonalIdNumber())
            ->setPolId($getPdfData->getPolId())
            ->setInsuranceSlug($getPdfData->getInsuranceSlug())
            ->setPdfTypeSlug($getPdfData->getPdfTypeSlug())
            ->setPolicyNumber($getPdfData->getPolicyNumber())
            ->setJsonData($getPdfData->getJsonData())
            ->setJsonProcessed($pdf->encodeJson($pdfData))
            ->setCreatedAt($now);

            return $this->pdfFileService->savePdfFile($pdf, false, false);
    }

    public function pdfModelName($pdfTypeSlug)
    {

        $pdfModel = $this->getContainer()->getParameter("pdf_type_slugs_model_class");
        return $pdfModel[$pdfTypeSlug];

    }

    public function pdfDecoratorName($pdfTypeSlug)
    {

        $pdfTypeSlugDecorator = $this->getContainer()->getParameter("pdf_type_slugs_decorator_class");
        return $pdfTypeSlugDecorator[$pdfTypeSlug];

    }

    public function isPdfFile($dirName, $fileName)
    {

        $webDownloadDir = "web" . $this->downloadFile . "/" . $dirName . "/" . $fileName;

        if (file_exists($webDownloadDir)) {
            return true;
        } else {
            return false;
        }

    }
}