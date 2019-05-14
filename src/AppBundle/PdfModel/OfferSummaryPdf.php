<?php

namespace AppBundle\PdfModel;


use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Teklif Özeti",
 *   type="object"
 * )
 */
class OfferSummaryPdf implements PdfModelInterface
{
    const PDF_TYPE_SLUG = '02-teklif-ozet';

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

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="Teklif Özeti PDF URL", example="http://www.example.com/teklif-ozeti.pdf")
     */
    private $offerSummaryPdfUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="Paraf Resim URL (Sigorta Ettiren)", example="http://www.example.com/paraf1.jpg")
     */
    private $insurerInitialsImageUrl;


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
     * @return OfferSummaryPdf
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
     * @return OfferSummaryPdf
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
     * @return OfferSummaryPdf
     */
    public function setIsArchivalRequired(bool $isArchivalRequired)
    {
        $this->isArchivalRequired = $isArchivalRequired;
        return $this;
    }

    /**
     * @param string $backUrl
     * @return OfferSummaryPdf
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
     * @return OfferSummaryPdf
     */
    public function setInsuranceSlug(string $insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;
        return $this;
    }

    /**
     * @return string
     */
    public function getOfferSummaryPdfUrl()
    {
        return $this->offerSummaryPdfUrl;
    }

    /**
     * @param string $offerSummaryPdfUrl
     * @return OfferSummaryPdf
     */
    public function setOfferSummaryPdfUrl(string $offerSummaryPdfUrl)
    {
        $this->offerSummaryPdfUrl = $offerSummaryPdfUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerInitialsImageUrl()
    {
        return $this->insurerInitialsImageUrl;
    }

    /**
     * @param string $insurerInitialsImageUrl
     * @return OfferSummaryPdf
     */
    public function setInsurerInitialsImageUrl(string $insurerInitialsImageUrl)
    {
        $this->insurerInitialsImageUrl = $insurerInitialsImageUrl;
        return $this;
    }
}
