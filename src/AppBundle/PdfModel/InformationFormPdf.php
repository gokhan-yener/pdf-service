<?php

namespace AppBundle\PdfModel;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Bilgilendirme Formu",
 *   type="object"
 * )
 */
class InformationFormPdf implements PdfModelInterface
{
    const PDF_TYPE_SLUG = '04-bilgilendirme-formu';

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
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Ticari Ünvan / Ad Soyad (Sigortacı)", example="Jane Doe")
     */
    private $mediatorName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Adres (Sigortacı)", example="Örnek Mah. Örnek Sok. No 5 Üsküdar-İstanbul")
     */
    private $mediatorAddress;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Tel. + Faks No", example="0 (216) 555 55 55 / 0 (216) 555 55 55")
     */
    private $mediatorPhoneFax;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Ad Soyad (Sigorta Ettiren)", example="Jane Doe")
     */
    private $insurerName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Tarih (Sigorta Ettiren)", example="01/01/2018")
     */
    private $insurerSigningDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="İmza Resim URL (Sigorta Ettiren)", example="http://www.example.com/imza1.jpg")
     */
    private $insurerSignImageUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="Paraf Resim URL (Sigorta Ettiren)", example="http://www.example.com/paraf1.jpg")
     */
    private $insurerInitialsImageUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Şirket Ünvanı", example="Örnek Şirketi Ltd.")
     */
    private $companyName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Ad Soyad (Şirket Yetkilisi)", example="Jane Doe")
     */
    private $companyEmployeeName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Tarih (Şirket Yetkilisi)", example="01/01/2018")
     */
    private $companySigningDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="İmza Resim URL (Şirket Yetkilisi)", example="http://www.example.com/imza2.jpg")
     */
    private $companySignImageUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=64, description="Eşik değer(Yüzde olarak) üst kısım", example="10")
     */
    private $thresholdValue;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=64, description="Eşik değer(Yüzde olarak) alt kısım", example="10")
     */
    private $thresholdValueDown;


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
     * @return InformationFormPdf
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
     * @return InformationFormPdf
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
     * @return InformationFormPdf
     */
    public function setIsArchivalRequired(bool $isArchivalRequired)
    {
        $this->isArchivalRequired = $isArchivalRequired;
        return $this;
    }

    /**
     * @param string $backUrl
     * @return InformationFormPdf
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
     * @return InformationFormPdf
     */
    public function setInsuranceSlug(string $insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;
        return $this;
    }

    /**
     * @return string
     */
    public function getMediatorName()
    {
        return $this->mediatorName;
    }

    /**
     * @param string $mediatorName
     * @return InformationFormPdf
     */
    public function setMediatorName(string $mediatorName)
    {
        $this->mediatorName = $mediatorName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMediatorAddress()
    {
        return $this->mediatorAddress;
    }

    /**
     * @param string $mediatorAddress
     * @return InformationFormPdf
     */
    public function setMediatorAddress(string $mediatorAddress)
    {
        $this->mediatorAddress = $mediatorAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getMediatorPhoneFax()
    {
        return $this->mediatorPhoneFax;
    }

    /**
     * @param string $mediatorPhoneFax
     * @return InformationFormPdf
     */
    public function setMediatorPhoneFax(string $mediatorPhoneFax)
    {
        $this->mediatorPhoneFax = $mediatorPhoneFax;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerName()
    {
        return $this->insurerName;
    }

    /**
     * @param string $insurerName
     * @return InformationFormPdf
     */
    public function setInsurerName(string $insurerName)
    {
        $this->insurerName = $insurerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerSigningDate()
    {
        return $this->insurerSigningDate;
    }

    /**
     * @param string $insurerSigningDate
     * @return InformationFormPdf
     */
    public function setInsurerSigningDate(string $insurerSigningDate)
    {
        $this->insurerSigningDate = $insurerSigningDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerSignImageUrl()
    {
        return $this->insurerSignImageUrl;
    }

    /**
     * @param string $insurerSignImageUrl
     * @return InformationFormPdf
     */
    public function setInsurerSignImageUrl(string $insurerSignImageUrl)
    {
        $this->insurerSignImageUrl = $insurerSignImageUrl;
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
     * @return InformationFormPdf
     */
    public function setInsurerInitialsImageUrl(string $insurerInitialsImageUrl)
    {
        $this->insurerInitialsImageUrl = $insurerInitialsImageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return InformationFormPdf
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyEmployeeName()
    {
        return $this->companyEmployeeName;
    }

    /**
     * @param string $companyEmployeeName
     * @return InformationFormPdf
     */
    public function setCompanyEmployeeName(string $companyEmployeeName)
    {
        $this->companyEmployeeName = $companyEmployeeName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanySigningDate()
    {
        return $this->companySigningDate;
    }

    /**
     * @param string $companySigningDate
     * @return InformationFormPdf
     */
    public function setCompanySigningDate(string $companySigningDate)
    {
        $this->companySigningDate = $companySigningDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanySignImageUrl()
    {
        return $this->companySignImageUrl;
    }

    /**
     * @param string $companySignImageUrl
     * @return InformationFormPdf
     */
    public function setCompanySignImageUrl(string $companySignImageUrl)
    {
        $this->companySignImageUrl = $companySignImageUrl;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getThresholdValue(): ?string
    {
        return $this->thresholdValue;
    }

    /**
     * @param string $thresholdValue
     */
    public function setThresholdValue(string $thresholdValue): self
    {
        $this->thresholdValue = $thresholdValue;
    }

    /**
     * @return null|string
     */
    public function getThresholdValueDown(): ?string
    {
        return $this->thresholdValueDown;
    }

    /**
     * @param string $thresholdValueDown
     */
    public function setThresholdValueDown(string $thresholdValueDown): self
    {
        $this->thresholdValueDown = $thresholdValueDown;
    }


}
