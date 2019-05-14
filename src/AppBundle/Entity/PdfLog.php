<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PdfLog
 *
 * @ORM\Table(
 *     name="aegon_pdf_log",
 *     indexes={
 *         @ORM\Index(name="idx_pdf_log_moreum_document_id", columns={"moreum_document_id"}),
 *         @ORM\Index(name="idx_pdf_log_personal_id_number", columns={"personal_id_number"}),
 *         @ORM\Index(name="idx_pdf_log_pol_id", columns={"pol_id"}),
 *         @ORM\Index(name="idx_pdf_log_policy_number", columns={"policy_number"}),
 *         @ORM\Index(name="idx_pdf_log_insurance_slug", columns={"insurance_slug"}),
 *         @ORM\Index(name="idx_pdf_log_pdf_type_slug", columns={"pdf_type_slug"}),
 *         @ORM\Index(name="idx_pdf_log_dir_name", columns={"dir_name"}),
 *         @ORM\Index(name="idx_pdf_log_file_name", columns={"file_name"}),
 *         @ORM\Index(name="idx_pdf_log_is_archival_required", columns={"is_archival_required"}),
 *         @ORM\Index(name="idx_pdf_log_created_at", columns={"created_at"}),
 *         @ORM\Index(name="idx_pdf_log_updated_at", columns={"updated_at"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PdfLogRepository")
 */
class PdfLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="moreum_document_id", type="integer", nullable=true)
     */
    private $moreumDocumentId;

    /**
     * @var string
     *
     * @ORM\Column(name="personal_id_number", type="string", length=11, nullable=false)
     */
    private $personalIdNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="pol_id", type="string", length=64, nullable=false)
     */
    private $polId;

    /**
     * @var string
     *
     * @ORM\Column(name="policy_number", type="string", length=64, nullable=true)
     */
    private $policyNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="insurance_slug", type="string", length=128, nullable=false)
     */
    private $insuranceSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="pdf_type_slug", type="string", length=128, nullable=false)
     */
    private $pdfTypeSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_name", type="string", length=128, nullable=false)
     */
    private $dirName;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=false)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="json_data", type="text", nullable=true)
     */
    private $jsonData;

    /**
     * @var string
     *
     * @ORM\Column(name="json_processed", type="text", nullable=true)
     */
    private $jsonProcessed;

    /**
     * @var boolean;
     *
     * @ORM\Column(name="is_archival_required", type="boolean", nullable=false)
     */
    private $isArchivalRequired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->isArchivalRequired = false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set moreumDocumentId
     *
     * @param integer $moreumDocumentId
     *
     * @return PdfLog
     */
    public function setMoreumDocumentId($moreumDocumentId)
    {
        $this->moreumDocumentId = $moreumDocumentId;

        return $this;
    }

    /**
     * Get moreumDocumentId
     *
     * @return integer
     */
    public function getMoreumDocumentId()
    {
        return $this->moreumDocumentId;
    }

    /**
     * Set personalIdNumber
     *
     * @param string $personalIdNumber
     *
     * @return PdfLog
     */
    public function setPersonalIdNumber($personalIdNumber)
    {
        $this->personalIdNumber = $personalIdNumber;

        return $this;
    }

    /**
     * Get personalIdNumber
     *
     * @return string
     */
    public function getPersonalIdNumber()
    {
        return $this->personalIdNumber;
    }

    /**
     * Set polId
     *
     * @param string $polId
     *
     * @return PdfLog
     */
    public function setPolId($polId)
    {
        $this->polId = $polId;

        return $this;
    }

    /**
     * Get polId
     *
     * @return string
     */
    public function getPolId()
    {
        return $this->polId;
    }

    /**
     * Set policyNumber
     *
     * @param string $policyNumber
     *
     * @return PdfLog
     */
    public function setPolicyNumber($policyNumber)
    {
        $this->policyNumber = $policyNumber;

        return $this;
    }

    /**
     * Get policyNumber
     *
     * @return string
     */
    public function getPolicyNumber()
    {
        return $this->policyNumber;
    }

    /**
     * Set insuranceSlug
     *
     * @param string $insuranceSlug
     *
     * @return PdfLog
     */
    public function setInsuranceSlug($insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;

        return $this;
    }

    /**
     * Get insuranceSlug
     *
     * @return string
     */
    public function getInsuranceSlug()
    {
        return $this->insuranceSlug;
    }

    /**
     * Set pdfTypeSlug
     *
     * @param string $pdfTypeSlug
     *
     * @return PdfLog
     */
    public function setPdfTypeSlug($pdfTypeSlug)
    {
        $this->pdfTypeSlug = $pdfTypeSlug;

        return $this;
    }

    /**
     * Get pdfTypeSlug
     *
     * @return string
     */
    public function getPdfTypeSlug()
    {
        return $this->pdfTypeSlug;
    }

    /**
     * Set dirName
     *
     * @param string $dirName
     *
     * @return PdfLog
     */
    public function setDirName($dirName)
    {
        $this->dirName = $dirName;

        return $this;
    }

    /**
     * Get dirName
     *
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return PdfLog
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set jsonData
     *
     * @param string $jsonData
     *
     * @return PdfLog
     */
    public function setJsonData($jsonData)
    {
        $this->jsonData = $jsonData;

        return $this;
    }

    /**
     * Get jsonData
     *
     * @return string
     */
    public function getJsonData()
    {
        return $this->jsonData;
    }

    /**
     * Set jsonProcessed
     *
     * @param string $jsonProcessed
     *
     * @return PdfLog
     */
    public function setJsonProcessed($jsonProcessed)
    {
        $this->jsonProcessed = $jsonProcessed;

        return $this;
    }

    /**
     * Get jsonProcessed
     *
     * @return string
     */
    public function getJsonProcessed()
    {
        return $this->jsonProcessed;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PdfLog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return PdfLog
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set isArchivalRequired
     *
     * @param boolean $isArchivalRequired
     *
     * @return PdfLog
     */
    public function setIsArchivalRequired($isArchivalRequired)
    {
        $this->isArchivalRequired = $isArchivalRequired;

        return $this;
    }

    /**
     * Get isArchivalRequired
     *
     * @return boolean
     */
    public function getIsArchivalRequired()
    {
        return $this->isArchivalRequired;
    }

    /**
     * @param Pdf $pdf
     * @return PdfLog
     */
    public function copyFromPdf(Pdf $pdf)
    {
        $this
            ->setMoreumDocumentId($pdf->getMoreumDocumentId())
            ->setPersonalIdNumber($pdf->getPersonalIdNumber())
            ->setPolId($pdf->getPolId())
            ->setPolicyNumber($pdf->getPolicyNumber())
            ->setInsuranceSlug($pdf->getInsuranceSlug())
            ->setPdfTypeSlug($pdf->getPdfTypeSlug())
            ->setDirName($pdf->getDirName())
            ->setFileName($pdf->getFileName())
            ->setJsonData($pdf->getJsonData())
            ->setJsonProcessed($pdf->getJsonProcessed())
            ->setIsArchivalRequired($pdf->getIsArchivalRequired())
            ->setCreatedAt($pdf->getCreatedAt())
            ->setUpdatedAt($pdf->getUpdatedAt())
        ;

        return $this;
    }
}
