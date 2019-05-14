<?php

namespace AppBundle\PdfModel;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="İhtiyaç Teyit",
 *   type="object"
 * )
 */
class RequirementsConfirmationPdf implements PdfModelInterface
{
    const PDF_TYPE_SLUG = '01-ihtiyac-teyit';

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
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Kendim (Sigorta lehdarı)")
     */
    private $isEndorsedHimself;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Eşim (Sigorta lehdarı)")
     */
    private $isEndorsedSpouse;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Çocuklarım (Sigorta lehdarı)")
     */
    private $isEndorsedChildren;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Diğer (Sigorta lehdarı)")
     */
    private $isEndorsedOther;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Ailenin zor durumda kalmaması (Amaç)")
     */
    private $isAimSecurityForFamily;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Hastalık durumunda masraf karşılanması (Amaç)")
     */
    private $isAimSecurityForIllness;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Primleri geri almak (Amaç)")
     */
    private $isAimChargeback;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Birikim (Amaç)")
     */
    private $isAimSaving;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Eğitim masraflarını karşılamak (Amaç)")
     */
    private $isAimEducationFunding;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%2 den az (Prim)")
     */
    private $isFeeLessThan2;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%2 - %5 (Prim)")
     */
    private $isFee2To5;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%5 - %10 (Prim)")
     */
    private $isFee5To10;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%10 - %20 (Prim)")
     */
    private $isFee10To20;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%20 den fazla (Prim)")
     */
    private $isFeeMoreThan20;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%2 den az (Toplam Prim)")
     */
    private $isTotalFeeLessThan2;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%2 - %5 (Toplam Prim)")
     */
    private $isTotalFee2To5;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%5 - %10 (Toplam Prim)")
     */
    private $isTotalFee5To10;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%10 - %20 (Toplam Prim)")
     */
    private $isTotalFee10To20;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="%20 den fazla (Toplam Prim)")
     */
    private $isTotalFeeMoreThan20;

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
     * @return RequirementsConfirmationPdf
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
     * @return RequirementsConfirmationPdf
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
     * @return RequirementsConfirmationPdf
     */
    public function setIsArchivalRequired(bool $isArchivalRequired)
    {
        $this->isArchivalRequired = $isArchivalRequired;
        return $this;
    }

    /**
     * @param string $backUrl
     * @return RequirementsConfirmationPdf
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
     * @return RequirementsConfirmationPdf
     */
    public function setInsuranceSlug(string $insuranceSlug)
    {
        $this->insuranceSlug = $insuranceSlug;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsEndorsedHimself()
    {
        return $this->isEndorsedHimself;
    }

    /**
     * @param bool $isEndorsedHimself
     * @return RequirementsConfirmationPdf
     */
    public function setIsEndorsedHimself(bool $isEndorsedHimself)
    {
        $this->isEndorsedHimself = $isEndorsedHimself;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsEndorsedSpouse()
    {
        return $this->isEndorsedSpouse;
    }

    /**
     * @param bool $isEndorsedSpouse
     * @return RequirementsConfirmationPdf
     */
    public function setIsEndorsedSpouse(bool $isEndorsedSpouse)
    {
        $this->isEndorsedSpouse = $isEndorsedSpouse;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsEndorsedChildren()
    {
        return $this->isEndorsedChildren;
    }

    /**
     * @param bool $isEndorsedChildren
     * @return RequirementsConfirmationPdf
     */
    public function setIsEndorsedChildren(bool $isEndorsedChildren)
    {
        $this->isEndorsedChildren = $isEndorsedChildren;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsEndorsedOther()
    {
        return $this->isEndorsedOther;
    }

    /**
     * @param bool $isEndorsedOther
     * @return RequirementsConfirmationPdf
     */
    public function setIsEndorsedOther(bool $isEndorsedOther)
    {
        $this->isEndorsedOther = $isEndorsedOther;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAimSecurityForFamily()
    {
        return $this->isAimSecurityForFamily;
    }

    /**
     * @param bool $isAimSecurityForFamily
     * @return RequirementsConfirmationPdf
     */
    public function setIsAimSecurityForFamily(bool $isAimSecurityForFamily)
    {
        $this->isAimSecurityForFamily = $isAimSecurityForFamily;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAimSecurityForIllness()
    {
        return $this->isAimSecurityForIllness;
    }

    /**
     * @param bool $isAimSecurityForIllness
     * @return RequirementsConfirmationPdf
     */
    public function setIsAimSecurityForIllness(bool $isAimSecurityForIllness)
    {
        $this->isAimSecurityForIllness = $isAimSecurityForIllness;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAimChargeback()
    {
        return $this->isAimChargeback;
    }

    /**
     * @param bool $isAimChargeback
     * @return RequirementsConfirmationPdf
     */
    public function setIsAimChargeback(bool $isAimChargeback)
    {
        $this->isAimChargeback = $isAimChargeback;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAimSaving()
    {
        return $this->isAimSaving;
    }

    /**
     * @param bool $isAimSaving
     * @return RequirementsConfirmationPdf
     */
    public function setIsAimSaving(bool $isAimSaving)
    {
        $this->isAimSaving = $isAimSaving;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAimEducationFunding()
    {
        return $this->isAimEducationFunding;
    }

    /**
     * @param bool $isAimEducationFunding
     * @return RequirementsConfirmationPdf
     */
    public function setIsAimEducationFunding(bool $isAimEducationFunding)
    {
        $this->isAimEducationFunding = $isAimEducationFunding;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFeeLessThan2()
    {
        return $this->isFeeLessThan2;
    }

    /**
     * @param bool $isFeeLessThan2
     * @return RequirementsConfirmationPdf
     */
    public function setIsFeeLessThan2(bool $isFeeLessThan2)
    {
        $this->isFeeLessThan2 = $isFeeLessThan2;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFee2To5()
    {
        return $this->isFee2To5;
    }

    /**
     * @param bool $isFee2To5
     * @return RequirementsConfirmationPdf
     */
    public function setIsFee2To5(bool $isFee2To5)
    {
        $this->isFee2To5 = $isFee2To5;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFee5To10()
    {
        return $this->isFee5To10;
    }

    /**
     * @param bool $isFee5To10
     * @return RequirementsConfirmationPdf
     */
    public function setIsFee5To10(bool $isFee5To10)
    {
        $this->isFee5To10 = $isFee5To10;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFee10To20()
    {
        return $this->isFee10To20;
    }

    /**
     * @param bool $isFee10To20
     * @return RequirementsConfirmationPdf
     */
    public function setIsFee10To20(bool $isFee10To20)
    {
        $this->isFee10To20 = $isFee10To20;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFeeMoreThan20()
    {
        return $this->isFeeMoreThan20;
    }

    /**
     * @param bool $isFeeMoreThan20
     * @return RequirementsConfirmationPdf
     */
    public function setIsFeeMoreThan20(bool $isFeeMoreThan20)
    {
        $this->isFeeMoreThan20 = $isFeeMoreThan20;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTotalFeeLessThan2()
    {
        return $this->isTotalFeeLessThan2;
    }

    /**
     * @param bool $isTotalFeeLessThan2
     * @return RequirementsConfirmationPdf
     */
    public function setIsTotalFeeLessThan2(bool $isTotalFeeLessThan2)
    {
        $this->isTotalFeeLessThan2 = $isTotalFeeLessThan2;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTotalFee2To5()
    {
        return $this->isTotalFee2To5;
    }

    /**
     * @param bool $isTotalFee2To5
     * @return RequirementsConfirmationPdf
     */
    public function setIsTotalFee2To5(bool $isTotalFee2To5)
    {
        $this->isTotalFee2To5 = $isTotalFee2To5;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTotalFee5To10()
    {
        return $this->isTotalFee5To10;
    }

    /**
     * @param bool $isTotalFee5To10
     * @return RequirementsConfirmationPdf
     */
    public function setIsTotalFee5To10(bool $isTotalFee5To10)
    {
        $this->isTotalFee5To10 = $isTotalFee5To10;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTotalFee10To20()
    {
        return $this->isTotalFee10To20;
    }

    /**
     * @param bool $isTotalFee10To20
     * @return RequirementsConfirmationPdf
     */
    public function setIsTotalFee10To20(bool $isTotalFee10To20)
    {
        $this->isTotalFee10To20 = $isTotalFee10To20;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTotalFeeMoreThan20()
    {
        return $this->isTotalFeeMoreThan20;
    }

    /**
     * @param bool $isTotalFeeMoreThan20
     * @return RequirementsConfirmationPdf
     */
    public function setIsTotalFeeMoreThan20(bool $isTotalFeeMoreThan20)
    {
        $this->isTotalFeeMoreThan20 = $isTotalFeeMoreThan20;
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
     * @return RequirementsConfirmationPdf
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
     * @return RequirementsConfirmationPdf
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
     * @return RequirementsConfirmationPdf
     */
    public function setInsurerSignImageUrl(string $insurerSignImageUrl)
    {
        $this->insurerSignImageUrl = $insurerSignImageUrl;
        return $this;
    }
}
