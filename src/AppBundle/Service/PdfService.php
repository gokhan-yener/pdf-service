<?php

namespace AppBundle\Service;

use AppBundle\Repository\PdfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Pdf;
use AppBundle\Entity\PdfLog;

class PdfService
{
    use DoctrineEnabledTrait;

    /**
     * @var PdfRepository
     */
    private $pdfRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     * @param PdfRepository $pdfRepository
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     */
    public function __construct(
        PdfRepository $pdfRepository,
        EntityManagerInterface $entityManager,
        ContainerInterface $container
    )
    {
        $this->pdfRepository = $pdfRepository;
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    /**
     * @param Pdf $pdf
     * @param bool $doFlush
     */
    public function savePdfEntity(Pdf $pdf, $doFlush = true)
    {
        $pdfLog = new PdfLog();
        $pdfLog->copyFromPdf($pdf);

        $this->entityManager->persist($pdf);
        $this->entityManager->persist($pdfLog);

        if ($doFlush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param string $personalIdNumber
     * @param string $polId
     * @param string $insuranceSlug
     * @param string $pdfTypeSlug
     * @param string $hydration
     * @return mixed
     */
    public function findOneByPersonalIdNumberAndPolIdAndSlugs(
        string $personalIdNumber,
        string $polId,
        string $insuranceSlug,
        string $pdfTypeSlug,
        string $hydration = 'object'
    )
    {
        $pdf = $this->pdfRepository->findOneByPersonalIdNumberAndPolIdAndSlugs(
            $personalIdNumber,
            $polId,
            $insuranceSlug,
            $pdfTypeSlug,
            $this->getHydrationMode($hydration)
        );

        return $pdf;
    }

    /**
     * @param string $personalIdNumber
     * @param string $polId
     * @param string $insuranceSlug
     * @param string $hydration
     * @return mixed
     */
    public function findAllByPersonalIdNumberAndPolIdAndInsuranceSlug(
        string $personalIdNumber,
        string $polId,
        string $insuranceSlug,
        string $hydration = 'array'
    )
    {
        $pdfs = $this->pdfRepository->findAllByPersonalIdNumberAndPolIdAndInsuranceSlug(
            $personalIdNumber,
            $polId,
            $insuranceSlug,
            $this->getHydrationMode($hydration)
        );

        $webDownloadDir = $this->container->getParameter('web_download_dir');

        if ($pdfs && 'array' === $hydration) {
            foreach ($pdfs as $key => $pdf) {
                $pdfs[$key]['url'] = $webDownloadDir . '/' . $pdf['dirName'] . '/' . $pdf['fileName'];
            }
        }

        return $pdfs;
    }

    /**
     * Returns all unarchived Pdf entities
     * @param $hydration
     * @return array
     */
    public function findAllUnarchived($hydration)
    {
        return $this->pdfRepository->findAllUnarchived($this->getHydrationMode($hydration));
    }
}
