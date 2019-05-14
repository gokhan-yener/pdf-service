<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Pdf
 *
 * @ORM\Table(
 *     name="aegon_pdf",
 *     indexes={
 *         @ORM\Index(name="idx_pdf_moreum_document_id", columns={"moreum_document_id"}),
 *         @ORM\Index(name="idx_pdf_personal_id_number", columns={"personal_id_number"}),
 *         @ORM\Index(name="idx_pdf_pol_id", columns={"pol_id"}),
 *         @ORM\Index(name="idx_pdf_policy_number", columns={"policy_number"}),
 *         @ORM\Index(name="idx_pdf_insurance_slug", columns={"insurance_slug"}),
 *         @ORM\Index(name="idx_pdf_pdf_type_slug", columns={"pdf_type_slug"}),
 *         @ORM\Index(name="idx_pdf_dir_name", columns={"dir_name"}),
 *         @ORM\Index(name="idx_pdf_file_name", columns={"file_name"}),
 *         @ORM\Index(name="idx_pdf_is_archival_required", columns={"is_archival_required"}),
 *         @ORM\Index(name="idx_pdf_created_at", columns={"created_at"}),
 *         @ORM\Index(name="idx_pdf_updated_at", columns={"updated_at"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PdfRepository")
 */
class Pdf
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
     * @param mixed|integer $moreumDocumentId
     *
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @return Pdf
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
     * @param array $data
     * @return string
     */
    public function encodeJson(array $data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 4096);
    }

    /**
     * @param string $json
     * @return array
     */
    public function decodeJson(string $json)
    {
        return json_decode($json, true);
    }

    /**
     * Set isArchivalRequired
     *
     * @param boolean $isArchivalRequired
     *
     * @return Pdf
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
}
