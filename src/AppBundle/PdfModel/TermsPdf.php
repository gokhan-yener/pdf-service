<?php

namespace AppBundle\PdfModel;


use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Özel ve Genel Şartlar",
 *   type="object"
 * )
 */
class TermsPdf implements PdfModelInterface
{
    const PDF_TYPE_SLUG = '05-ozel-ve-genel-sartlar';

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=64, maxLength=64, description="Sigorta Türü Kodu (insuranceSlug)", example="5-5-odullu-birikim")
     */
    private $insuranceSlug;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=64, description="POLID", example="2223524")
     */
    private $polId;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=64, description="Poliçe No", example="ROP_AD_3017060001")
     */
    private $policyNumber;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Moreum Arşifleme Yapılsın mı?")
     */
    private $isArchivalRequired;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=1024, description="Geri gitme linki (index)", example="http://www.example.com")
     */
    private $backUrl;


    public function __construct(string $insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;
    }

    /**
     * @return string
     */
    public function getPolId()
    {
        return $this->polId;
    }

    /**
     * @param string $polId
     * @return TermsPdf
     */
    public function setPolId(string $polId)
    {
        $this->polId = $polId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPolicyNumber()
    {
        return $this->policyNumber;
    }

    /**
     * @param string $policyNumber
     * @return TermsPdf
     */
    public function setPolicyNumber(string $policyNumber)
    {
        $this->policyNumber = $policyNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPdfTypeSlug()
    {
        return self::PDF_TYPE_SLUG;
    }

    /**
     * @return bool
     */
    public function getIsArchivalRequired()
    {
        return $this->isArchivalRequired;
    }

    /**
     * @param bool $isArchivalRequired
     * @return TermsPdf
     */
    public function setIsArchivalRequired(bool $isArchivalRequired)
    {
        $this->isArchivalRequired = $isArchivalRequired;
        return $this;
    }

    /**
     * @param string $backUrl
     * @return TermsPdf
     */
    public function setBackUrl(string $backUrl)
    {
        $this->backUrl = $backUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->backUrl;
    }

    /**
     * @return string
     */
    public function getInsuranceSlug()
    {
        return $this->insuranceSlug;
    }

    /**
     * @param string $insuranceSlug
     * @return TermsPdf
     */
    public function setInsuranceSlug(string $insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;
        return $this;
    }
}
