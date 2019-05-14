<?php

namespace AppBundle\PdfModel;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Poliçe",
 *   type="object"
 * )
 */
class PolicyPdf implements PdfModelInterface
{
    const PDF_TYPE_SLUG = '06-police';

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
     * @var array Details
     * @JMS\Type("array<AppBundle\PdfModel\PolicyPdf\PolicyDetail>")
     * @SWG\Property(
     *     type="array",
     *     description="Poliçe Bilgileri (1. Sayfa)",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\PolicyPdf\PolicyDetail::class))
     * )
     */
    private $details;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=1024, description="Dipnot (Poliçe Bilgileri)", example="(*) Devam eden yıllar için prim ödeme vadeleri takip eden yılların ...")
     */
    private $detailsFootnote;

    /**
     * @var array Guarantees
     * @JMS\Type("array<AppBundle\PdfModel\PolicyPdf\PolicyGuarantee>")
     * @SWG\Property(
     *     type="array",
     *     description="Poliçe: Teminatlar",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\PolicyPdf\PolicyGuarantee::class))
     * )
     */
    private $guarantees;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=1024, description="Dipnot (Teminatlar)", example="(*) Vefat Teminatı ve Süre Sonu Prim Iadesi Teminatı için lütfen ...")
     */
    private $guaranteesFootnote;

    /**
     * @var array PaybackYears
     * @JMS\Type("array<AppBundle\PdfModel\PolicyPdf\PolicyPaybackYear>")
     * @SWG\Property(
     *     type="array",
     *     description="Poliçe: Yıllık Geri Ödeme Tarihleri (sadece Eğitim İçin HS içindir)",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\PolicyPdf\PolicyPaybackYear::class))
     * )
     */
    private $paybackYears;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=1024, description="Dipnot (Yıllık Geri Ödeme Tarihleri)", example="(**) Geri ödemel koşulları, Eğitim İçin Hayat Sigortası Özel Şartları 3.9 maddesinde açıklanmıştır ...")
     */
    private $paybackYearsFootnote;

    /**
     * @var array RedemptionFees
     * @JMS\Type("array<AppBundle\PdfModel\PolicyPdf\PolicyRedemptionFee>")
     * @SWG\Property(
     *     type="array",
     *     description="Poliçe: Matematik Karşılık ve İştira Bedeli (sadece 'Ferdi Kazalı Prim İadeli HS' ve 'Prim İadeli HS' için geçerlidir)",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\PolicyPdf\PolicyRedemptionFee::class))
     * )
     */
    private $redemptionFees;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Adı Soyadı (Sigorta Ettiren)", example="John Doe")
     */
    private $insurerName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Doğum Tarihi (Sigorta Ettiren)", example="01/01/1980")
     */
    private $insurerBirthDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=1, description="Cinsiyet (Sigorta Ettiren)", example="E", enum={"E", "K"})
     */
    private $insurerGender;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Doğum Yeri (Sigorta Ettiren)", example="Kocaeli")
     */
    private $insurerBirthPlace;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Adres (Sigorta Ettiren)", example="Örnek Mah. Örnek Sok. No 5 Üsküdar-İstanbul")
     */
    private $insurerAddress;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Adı Soyadı (Sigortalı)", example="John Doe")
     */
    private $insuredName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Doğum Tarihi (Sigortalı)", example="01/01/1980")
     */
    private $insuredBirthDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=1, description="Cinsiyet (Sigortalı)", example="E", enum={"E", "K"})
     */
    private $insuredGender;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Doğum Yeri (Sigortalı)", example="Kocaeli")
     */
    private $insuredBirthPlace;

    /**
     * @var array Endorseds
     * @JMS\Type("array<AppBundle\PdfModel\PolicyPdf\PolicyEndorsed>")
     * @SWG\Property(
     *     type="array",
     *     description="Poliçe Lehdarları",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\PolicyPdf\PolicyEndorsed::class))
     * )
     */
    private $endorseds;

    /**
     * @var array MediatorDetails
     * @JMS\Type("array<AppBundle\PdfModel\PolicyPdf\PolicyMediatorDetail>")
     * @SWG\Property(
     *     type="array",
     *     description="Poliçe Aracı Bilgileri",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\PolicyPdf\PolicyMediatorDetail::class))
     * )
     */
    private $mediatorDetails;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Aracı Şirket Adı", example="Örnek Sigorta Acentesi Ltd.")
     */
    private $companyName;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="İmzalandı mı?")
     */
    private $isSigned;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Düzenleme Tarihi", example="01/01/2018")
     */
    private $signingDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="İmza Resim URL (Aracı Şirket)", example="http://www.example.com/imza1.jpg")
     */
    private $companySignImageUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="İmza Resim URL (AEGON)", example="http://www.example.com/imza1.jpg")
     */
    private $aegonSignImageUrl;



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
     * @return PolicyPdf
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
     * @return PolicyPdf
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
     * @return PolicyPdf
     */
    public function setIsArchivalRequired(bool $isArchivalRequired)
    {
        $this->isArchivalRequired = $isArchivalRequired;
        return $this;
    }

    /**
     * @param string $backUrl
     * @return PolicyPdf
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
     * @return PolicyPdf
     */
    public function setInsuranceSlug(string $insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;
        return $this;
    }

    /**
     * @return array
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param array $details
     * @return PolicyPdf
     */
    public function setDetails(array $details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return string
     */
    public function getDetailsFootnote()
    {
        return $this->detailsFootnote;
    }

    /**
     * @param string $detailsFootnote
     * @return PolicyPdf
     */
    public function setDetailsFootnote(string $detailsFootnote)
    {
        $this->detailsFootnote = $detailsFootnote;
        return $this;
    }

    /**
     * @return array
     */
    public function getGuarantees()
    {
        return $this->guarantees;
    }

    /**
     * @param array $guarantees
     * @return PolicyPdf
     */
    public function setGuarantees(array $guarantees)
    {
        $this->guarantees = $guarantees;
        return $this;
    }

    /**
     * @return string
     */
    public function getGuaranteesFootnote()
    {
        return $this->guaranteesFootnote;
    }

    /**
     * @param string $guaranteesFootnote
     * @return PolicyPdf
     */
    public function setGuaranteesFootnote(string $guaranteesFootnote)
    {
        $this->guaranteesFootnote = $guaranteesFootnote;
        return $this;
    }

    /**
     * @return array
     */
    public function getPaybackYears(): array
    {
        return $this->paybackYears;
    }

    /**
     * @param array $paybackYears
     * @return PolicyPdf
     */
    public function setPaybackYears(array $paybackYears)
    {
        $this->paybackYears = $paybackYears;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaybackYearsFootnote()
    {
        return $this->paybackYearsFootnote;
    }

    /**
     * @param string $paybackYearsFootnote
     * @return PolicyPdf
     */
    public function setPaybackYearsFootnote(string $paybackYearsFootnote)
    {
        $this->paybackYearsFootnote = $paybackYearsFootnote;
        return $this;
    }

    /**
     * @return array
     */
    public function getRedemptionFees()
    {
        return $this->redemptionFees;
    }

    /**
     * @param array $redemptionFees
     * @return PolicyPdf
     */
    public function setRedemptionFees(array $redemptionFees)
    {
        $this->redemptionFees = $redemptionFees;
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
     * @return PolicyPdf
     */
    public function setInsurerName(string $insurerName)
    {
        $this->insurerName = $insurerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerBirthDate()
    {
        return $this->insurerBirthDate;
    }

    /**
     * @param string $insurerBirthDate
     * @return PolicyPdf
     */
    public function setInsurerBirthDate(string $insurerBirthDate)
    {
        $this->insurerBirthDate = $insurerBirthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerGender()
    {
        return $this->insurerGender;
    }

    /**
     * @param string $insurerGender
     * @return PolicyPdf
     */
    public function setInsurerGender(string $insurerGender)
    {
        $this->insurerGender = $insurerGender;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerBirthPlace()
    {
        return $this->insurerBirthPlace;
    }

    /**
     * @param string $insurerBirthPlace
     * @return PolicyPdf
     */
    public function setInsurerBirthPlace(string $insurerBirthPlace)
    {
        $this->insurerBirthPlace = $insurerBirthPlace;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerAddress()
    {
        return $this->insurerAddress;
    }

    /**
     * @param string $insurerAddress
     * @return PolicyPdf
     */
    public function setInsurerAddress(string $insurerAddress)
    {
        $this->insurerAddress = $insurerAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsuredName()
    {
        return $this->insuredName;
    }

    /**
     * @param string $insuredName
     * @return PolicyPdf
     */
    public function setInsuredName(string $insuredName)
    {
        $this->insuredName = $insuredName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsuredBirthDate()
    {
        return $this->insuredBirthDate;
    }

    /**
     * @param string $insuredBirthDate
     * @return PolicyPdf
     */
    public function setInsuredBirthDate(string $insuredBirthDate)
    {
        $this->insuredBirthDate = $insuredBirthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsuredGender()
    {
        return $this->insuredGender;
    }

    /**
     * @param string $insuredGender
     * @return PolicyPdf
     */
    public function setInsuredGender(string $insuredGender)
    {
        $this->insuredGender = $insuredGender;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsuredBirthPlace()
    {
        return $this->insuredBirthPlace;
    }

    /**
     * @param string $insuredBirthPlace
     * @return PolicyPdf
     */
    public function setInsuredBirthPlace(string $insuredBirthPlace)
    {
        $this->insuredBirthPlace = $insuredBirthPlace;
        return $this;
    }

    /**
     * @return array
     */
    public function getEndorseds(): array
    {
        return $this->endorseds;
    }

    /**
     * @param array $endorseds
     * @return PolicyPdf
     */
    public function setEndorseds(array $endorseds)
    {
        $this->endorseds = $endorseds;
        return $this;
    }

    /**
     * @return array
     */
    public function getMediatorDetails()
    {
        return $this->mediatorDetails;
    }

    /**
     * @param array $mediatorDetails
     * @return PolicyPdf
     */
    public function setMediatorDetails(array $mediatorDetails)
    {
        $this->mediatorDetails = $mediatorDetails;
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
     * @return PolicyPdf
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSigned()
    {
        return $this->isSigned;
    }

    /**
     * @param bool $isSigned
     * @return PolicyPdf
     */
    public function setIsSigned(bool $isSigned)
    {
        $this->isSigned = $isSigned;
        return $this;
    }

    /**
     * @return string
     */
    public function getSigningDate()
    {
        return $this->signingDate;
    }

    /**
     * @param string $signingDate
     * @return PolicyPdf
     */
    public function setSigningDate(string $signingDate)
    {
        $this->signingDate = $signingDate;
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
     * @return PolicyPdf
     */
    public function setCompanySignImageUrl(string $companySignImageUrl)
    {
        $this->companySignImageUrl = $companySignImageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getAegonSignImageUrl()
    {
        return $this->aegonSignImageUrl;
    }

    /**
     * @param string $aegonSignImageUrl
     * @return PolicyPdf
     */
    public function setAegonSignImageUrl(string $aegonSignImageUrl)
    {
        $this->aegonSignImageUrl = $aegonSignImageUrl;
        return $this;
    }
}
