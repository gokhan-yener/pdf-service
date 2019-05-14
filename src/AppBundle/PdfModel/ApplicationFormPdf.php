<?php

namespace AppBundle\PdfModel;

use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormGuarantee;
use AppBundle\PdfModel\ApplicationFormPdf\Person;
use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormMediator;
use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormEndorsed;
use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormCreditCard;

use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsuredPerson;
use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsurerPerson;
use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsurerCompany;

use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormLifestyle;
use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormHealthBasic;
use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormHealthExtended;

use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormConfirmation;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;
use AppBundle\PdfDecorator\AbstractPdfDecorator;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu",
 *   type="object"
 * )
 */
class ApplicationFormPdf implements PdfModelInterface
{
    const PDF_TYPE_SLUG = '03-basvuru-formu';

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=64, description="Sigorta Türü Kodu (insuranceSlug)", example="5-5-odullu-birikim")
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
     * @SWG\Property(type="string", minLength=10, maxLength=10, description="Başvuru No", example="1234567890")
     */
    private $applicationNumber;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=6, maxLength=6, description="Kampanya Kodu", example="1234567")
     */
    private $campaignCode;

    /**
     * @var array Guarantees
     * @JMS\Type("array<AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormGuarantee>")
     * @SWG\Property(
     *     type="array",
     *     description="Teminatlar",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormGuarantee::class))
     * )
     */
    private $guarantees;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=1024, description="Açıklama (Teminatlar)", example="*KAP'ın yıllık prim tutarı kadar olan teminatlar yıl bazında ödenirken, ...")
     */
    private $guaranteesExplanation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Başlangıç Tarihi", example="01/01/2018")
     */
    private $startDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Bitiş Tarihi", example="01/01/2023")
     */
    private $endDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=8, description="Süresi (Yıl)", example="10")
     */
    private $durationYears;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=16, description="Yıllık Prim Tutarı", example="1.000")
     */
    private $yearlyPrice;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=3, example="TL", enum={"TL", "$"})
     */
    private $yearlyPriceCurrency;

    /**
     * @var array CreditCards
     * @JMS\Type("array<AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormCreditCard>")
     * @SWG\Property(
     *     type="array",
     *     description="Kredi Kart(lar)ı",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormCreditCard::class))
     * )
     */
    private $creditCards;

    /**
     * @var array BankAccountInfos
     * @JMS\Type("array<AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormBankAccountInfo>")
     * @SWG\Property(
     *     type="array",
     *     description="Otomatik Ödeme - Banka Hesabı Bilgileri",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormBankAccountInfo::class))
     * )
     */
    private $bankAccountInfos;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=3, description="Ödeme Sıklığı (Ay)", example="6", enum={"1", "3", "6", "12"})
     */
    private $paymentPeriodMonths;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Dönemsel Prim Tutarı", example="1.000")
     */
    private $periodicalPrice;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=3, example="TL", enum={"TL", "$"})
     */
    private $periodicalPriceCurrency;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="İlk Prim Tahsilat Tarihi", example="01/01/2018")
     */
    private $firstPaymentDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=3, description="Aylık prim ödeme günü", example="15")
     */
    private $monthlyPaymentDay;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Sigorta Ettiren", example="John Doe")
     */
    private $insurerName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Sigorta Ettiren (TCKN)", example="012345678901")
     */
    private $insurerPersonalId;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Sigortalı", example="Jane Doe")
     */
    private $insuredName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Sigortalı (TCKN)", example="012345678901")
     */
    private $insuredPersonalId;

    /**
     * @var array Endorseds
     * @JMS\Type("array<AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormEndorsed>")
     * @SWG\Property(
     *     type="array",
     *     description="Lehdarlar",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormEndorsed::class))
     * )
     */
    private $endorseds;

    /**
     * @var ApplicationFormMediator
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormMediator")
     * @SWG\Property(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormMediator::class))
     */
    private $mediator;

    /**
     * @var ApplicationFormInsuredPerson
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsuredPerson")
     * @SWG\Property(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsuredPerson::class))
     */
    private $insuredPerson;

    /**
     * @var ApplicationFormInsurerPerson
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsurerPerson")
     * @SWG\Property(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsurerPerson::class))
     */
    private $insurerPerson;

    /**
     * @var ApplicationFormInsurerCompany
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsurerCompany")
     * @SWG\Property(ref=@Model(type=ApplicationFormPdf\ApplicationFormInsurerCompany::class))
     */
    private $insurerCompany;

    /**
     * @var ApplicationFormLifestyle
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormLifestyle")
     * @SWG\Property(ref=@Model(type=ApplicationFormPdf\ApplicationFormLifestyle::class))
     */
    private $lifestyle;

    /**
     * @var ApplicationFormHealthBasic
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormHealthBasic")
     * @SWG\Property(ref=@Model(type=ApplicationFormPdf\ApplicationFormHealthBasic::class))
     */
    private $healthBasic;

    /**
     * @var ApplicationFormHealthExtended
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormHealthExtended")
     * @SWG\Property(ref=@Model(type=ApplicationFormPdf\ApplicationFormHealthExtended::class))
     */
    private $healthExtended;

    /**
     * @var ApplicationFormConfirmation
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormConfirmation")
     * @SWG\Property(ref=@Model(type=ApplicationFormPdf\ApplicationFormConfirmation::class))
     */
    private $confirmation;


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
     * @return ApplicationFormPdf
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
     * @return ApplicationFormPdf
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
     * @return ApplicationFormPdf
     */
    public function setIsArchivalRequired(bool $isArchivalRequired)
    {
        $this->isArchivalRequired = $isArchivalRequired;
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
     * @param string $backUrl
     * @return ApplicationFormPdf
     */
    public function setBackUrl(string $backUrl)
    {
        $this->backUrl = $backUrl;
        return $this;
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
     * @return ApplicationFormPdf
     */
    public function setInsuranceSlug(string $insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationNumber()
    {
        return $this->applicationNumber;
    }

    /**
     * @param string $applicationNumber
     * @return ApplicationFormPdf
     */
    public function setApplicationNumber(string $applicationNumber)
    {
        $this->applicationNumber = $applicationNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCampaignCode()
    {
        return $this->campaignCode;
    }

    /**
     * @param string $campaignCode
     * @return ApplicationFormPdf
     */
    public function setCampaignCode(string $campaignCode)
    {
        $this->campaignCode = $campaignCode;
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
     * @return ApplicationFormPdf
     */
    public function setGuarantees(array $guarantees)
    {
        $this->guarantees = $guarantees;
        return $this;
    }

    /**
     * @return string
     */
    public function getGuaranteesExplanation()
    {
        return $this->guaranteesExplanation;
    }

    /**
     * @param string $guaranteesExplanation
     * @return ApplicationFormPdf
     */
    public function setGuaranteesExplanation(string $guaranteesExplanation)
    {
        $this->guaranteesExplanation = $guaranteesExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     * @return ApplicationFormPdf
     */
    public function setStartDate(string $startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     * @return ApplicationFormPdf
     */
    public function setEndDate(string $endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getDurationYears()
    {
        return $this->durationYears;
    }

    /**
     * @param string $durationYears
     * @return ApplicationFormPdf
     */
    public function setDurationYears(string $durationYears)
    {
        $this->durationYears = $durationYears;
        return $this;
    }

    /**
     * @return string
     */
    public function getYearlyPrice()
    {
        return $this->yearlyPrice;
    }

    /**
     * @param string $yearlyPrice
     * @return ApplicationFormPdf
     */
    public function setYearlyPrice(string $yearlyPrice)
    {
        $this->yearlyPrice = $yearlyPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getYearlyPriceCurrency()
    {
        return $this->yearlyPriceCurrency;
    }

    /**
     * @param string $yearlyPriceCurrency
     * @return ApplicationFormPdf
     */
    public function setYearlyPriceCurrency(string $yearlyPriceCurrency)
    {
        $this->yearlyPriceCurrency = $yearlyPriceCurrency;
        return $this;
    }

    /**
     * @return array
     */
    public function getCreditCards()
    {
        return $this->creditCards;
    }

    /**
     * @param array $creditCards
     * @return ApplicationFormPdf
     */
    public function setCreditCards(array $creditCards)
    {
        $this->creditCards = $creditCards;
        return $this;
    }

    /**
     * @return array
     */
    public function getBankAccountInfos()
    {
        return $this->bankAccountInfos;
    }

    /**
     * @param array $bankAccountInfos
     * @return ApplicationFormPdf
     */
    public function setBankAccountInfos(array $bankAccountInfos)
    {
        $this->bankAccountInfos = $bankAccountInfos;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentPeriodMonths()
    {
        return $this->paymentPeriodMonths;
    }

    /**
     * @param string $paymentPeriodMonths
     * @return ApplicationFormPdf
     */
    public function setPaymentPeriodMonths(string $paymentPeriodMonths)
    {
        $this->paymentPeriodMonths = $paymentPeriodMonths;
        return $this;
    }

    /**
     * @return string
     */
    public function getPeriodicalPrice()
    {
        return $this->periodicalPrice;
    }

    /**
     * @param string $periodicalPrice
     * @return ApplicationFormPdf
     */
    public function setPeriodicalPrice(string $periodicalPrice)
    {
        $this->periodicalPrice = $periodicalPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getPeriodicalPriceCurrency()
    {
        return $this->periodicalPriceCurrency;
    }

    /**
     * @param string $periodicalPriceCurrency
     * @return ApplicationFormPdf
     */
    public function setPeriodicalPriceCurrency(string $periodicalPriceCurrency)
    {
        $this->periodicalPriceCurrency = $periodicalPriceCurrency;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstPaymentDate()
    {
        return $this->firstPaymentDate;
    }

    /**
     * @param string $firstPaymentDate
     * @return ApplicationFormPdf
     */
    public function setFirstPaymentDate(string $firstPaymentDate)
    {
        $this->firstPaymentDate = $firstPaymentDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getMonthlyPaymentDay()
    {
        return $this->monthlyPaymentDay;
    }

    /**
     * @param string $monthlyPaymentDay
     * @return ApplicationFormPdf
     */
    public function setMonthlyPaymentDay(string $monthlyPaymentDay)
    {
        $this->monthlyPaymentDay = $monthlyPaymentDay;
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
     * @return ApplicationFormPdf
     */
    public function setInsurerName(string $insurerName)
    {
        $this->insurerName = $insurerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerPersonalId()
    {
        return $this->insurerPersonalId;
    }

    /**
     * @param string $insurerPersonalId
     * @return ApplicationFormPdf
     */
    public function setInsurerPersonalId(string $insurerPersonalId)
    {
        $this->insurerPersonalId = $insurerPersonalId;
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
     * @return ApplicationFormPdf
     */
    public function setInsuredName(string $insuredName)
    {
        $this->insuredName = $insuredName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsuredPersonalId()
    {
        return $this->insuredPersonalId;
    }

    /**
     * @param string $insuredPersonalId
     * @return ApplicationFormPdf
     */
    public function setInsuredPersonalId(string $insuredPersonalId)
    {
        $this->insuredPersonalId = $insuredPersonalId;
        return $this;
    }

    /**
     * @return array
     */
    public function getEndorseds()
    {
        return $this->endorseds;
    }

    /**
     * @param array $endorseds
     * @return ApplicationFormPdf
     */
    public function setEndorseds(array $endorseds)
    {
        $this->endorseds = $endorseds;
        return $this;
    }

    /**
     * @return ApplicationFormMediator
     */
    public function getMediator()
    {
        return $this->mediator;
    }

    /**
     * @param ApplicationFormMediator $mediator
     * @return ApplicationFormPdf
     */
    public function setMediator(ApplicationFormMediator $mediator)
    {
        $this->mediator = $mediator;
        return $this;
    }

    /**
     * @return ApplicationFormInsuredPerson
     */
    public function getInsuredPerson()
    {
        return $this->insuredPerson;
    }

    /**
     * @param ApplicationFormInsuredPerson $insuredPerson
     * @return ApplicationFormPdf
     */
    public function setInsuredPerson(ApplicationFormInsuredPerson $insuredPerson)
    {
        $this->insuredPerson = $insuredPerson;
        return $this;
    }

    /**
     * @return ApplicationFormInsurerPerson
     */
    public function getInsurerPerson()
    {
        return $this->insurerPerson;
    }

    /**
     * @param ApplicationFormInsurerPerson $insurerPerson
     * @return ApplicationFormPdf
     */
    public function setInsurerPerson(ApplicationFormInsurerPerson $insurerPerson)
    {
        $this->insurerPerson = $insurerPerson;
        return $this;
    }

    /**
     * @return ApplicationFormInsurerCompany
     */
    public function getInsurerCompany()
    {
        return $this->insurerCompany;
    }

    /**
     * @param ApplicationFormInsurerCompany $insurerCompany
     * @return ApplicationFormPdf
     */
    public function setInsurerCompany(ApplicationFormInsurerCompany $insurerCompany)
    {
        $this->insurerCompany = $insurerCompany;
        return $this;
    }

    /**
     * @return ApplicationFormLifestyle
     */
    public function getLifestyle()
    {
        return $this->lifestyle;
    }

    /**
     * @param ApplicationFormLifestyle $lifestyle
     * @return ApplicationFormPdf
     */
    public function setLifestyle(ApplicationFormLifestyle $lifestyle)
    {
        $this->lifestyle = $lifestyle;
        return $this;
    }

    /**
     * @return ApplicationFormHealthBasic
     */
    public function getHealthBasic()
    {
        return $this->healthBasic;
    }

    /**
     * @param ApplicationFormHealthBasic $healthBasic
     * @return ApplicationFormPdf
     */
    public function setHealthBasic(ApplicationFormHealthBasic $healthBasic)
    {
        $this->healthBasic = $healthBasic;
        return $this;
    }

    /**
     * @return ApplicationFormHealthExtended
     */
    public function getHealthExtended()
    {
        return $this->healthExtended;
    }

    /**
     * @param ApplicationFormHealthExtended $healthExtended
     * @return ApplicationFormPdf
     */
    public function setHealthExtended(ApplicationFormHealthExtended $healthExtended)
    {
        $this->healthExtended = $healthExtended;
        return $this;
    }

    /**
     * @return ApplicationFormConfirmation
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * @param ApplicationFormConfirmation $confirmation
     * @return ApplicationFormPdf
     */
    public function setConfirmation(ApplicationFormConfirmation $confirmation)
    {
        $this->confirmation = $confirmation;
        return $this;
    }
}
