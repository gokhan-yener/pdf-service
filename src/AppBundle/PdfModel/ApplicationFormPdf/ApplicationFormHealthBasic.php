<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Sağlık Bilgileri (5 Soru)",
 *   type="object"
 * )
 */
class ApplicationFormHealthBasic
{
    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Son 24 ay içinde bir tıp doktoruna başvurdunuz mu ...")
     */
    private $hasVisitedPhysician;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, example="1 hafta önce grip olmuştum")
     */
    private $hasVisitedPhysicianExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Son 5 yıl içinde bir hastalık için 14 günden fazla ilaç tedavisi ...")
     */
    private $hasTakenMedications;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, example="1 hafta önce antibiotik aldım")
     */
    private $hasTakenMedicationsExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Kalp Hastalığı")
     */
    private $hasIllnessHeart;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Sinir Sistemi")
     */
    private $hasIllnessNervousSystem;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Kolit")
     */
    private $hasIllnessColitis;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Şeker Hastalığı")
     */
    private $hasIllnessDiabetes;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Felç")
     */
    private $hasIllnessParalysis;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Diğer kronik veya uzun süreli hastalıklar")
     */
    private $hasIllnessOthers;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Böbrek Hastalığı")
     */
    private $hasIllnessKidneys;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Kanser")
     */
    private $hasIllnessCancer;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Hipertansiyon")
     */
    private $hasIllnessHypertension;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Hepatit")
     */
    private $hasIllnessHepatitis;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Bu güne kadar hiç maluliyet ödemesi aldınız mı ...")
     */
    private $hasReceivedDisabilitiesPayment;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, example="5 senedir maluliyet ödemesi alıyorum")
     */
    private $hasReceivedDisabilitiesPaymentExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Herhangi bir hayat sigortası başvuru ... reddedildi mi ...")
     */
    private $hasDeclinedApplicationForInsurance;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, example="1 yıl önce de başvurmuşttum, kabul edilmedi")
     */
    private $hasDeclinedApplicationForInsuranceExplanation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, example="Diğer-Açıklama")
     */
    private $hasIllnessExplanation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=1024, description="Sürprim Teminat Tablosu Açıklaması", example="Başvurunuza istinaden yapılan ön değerlendirme sonuçları ...")
     */
    private $additionalGuaranteesExplanation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Teminat Tablosu (1. Başlık): Teminat İsmi", example="Teminat")
     */
    private $additionalGuaranteesNameTitle;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Teminat Tablosu (2. Başlık): Uygulama Öncesi", example="Uygulama Öncesi")
     */
    private $additionalGuaranteesBeforeTitle;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Teminat Tablosu (3. Başlık): Sürprim Oranı", example="Sürprim Oranı")
     */
    private $additionalGuaranteesPercentTitle;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Teminat Tablosu (4. Başlık): Uygulama Sonrası", example="Prim Artışı", enum={"Prim Artışı", "Teminat Azalışı"})
     */
    private $additionalGuaranteesAfterTitle;

    /**
     * @var array HealthAdditionalGuaranteesTable
     * @JMS\Type("array<AppBundle\PdfModel\ApplicationFormPdf\HealthAdditionalGuaranteesTableRow>")
     * @SWG\Property(
     *     type="array",
     *     description="Sürprim Teminat Tablosu Satırları",
     *     @SWG\Items(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\HealthAdditionalGuaranteesTableRow::class))
     * )
     */
    private $additionalGuaranteesTableRows;

    /**
     * @return bool
     */
    public function getHasVisitedPhysician()
    {
        return $this->hasVisitedPhysician;
    }

    /**
     * @param bool $hasVisitedPhysician
     * @return ApplicationFormHealthBasic
     */
    public function setHasVisitedPhysician(bool $hasVisitedPhysician)
    {
        $this->hasVisitedPhysician = $hasVisitedPhysician;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasVisitedPhysicianExplanation()
    {
        return $this->hasVisitedPhysicianExplanation;
    }

    /**
     * @param string $hasVisitedPhysicianExplanation
     * @return ApplicationFormHealthBasic
     */
    public function setHasVisitedPhysicianExplanation(string $hasVisitedPhysicianExplanation)
    {
        $this->hasVisitedPhysicianExplanation = $hasVisitedPhysicianExplanation;
        return $this;
    }
    /**
     * @return string
     */
    public function getHasIllnessExplanation()
    {
        return $this->hasIllnessExplanation;
    }

    /**
     * @param string $hasVisitedPhysicianExplanation
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessExplanation(string $hasIllnessExplanation)
    {
        $this->hasIllnessExplanation = $hasIllnessExplanation;
        return $this;
    }
    /**
     * @return bool
     */
    public function getHasTakenMedications()
    {
        return $this->hasTakenMedications;
    }

    /**
     * @param bool $hasTakenMedications
     * @return ApplicationFormHealthBasic
     */
    public function setHasTakenMedications(bool $hasTakenMedications)
    {
        $this->hasTakenMedications = $hasTakenMedications;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasTakenMedicationsExplanation()
    {
        return $this->hasTakenMedicationsExplanation;
    }

    /**
     * @param string $hasTakenMedicationsExplanation
     * @return ApplicationFormHealthBasic
     */
    public function setHasTakenMedicationsExplanation(string $hasTakenMedicationsExplanation)
    {
        $this->hasTakenMedicationsExplanation = $hasTakenMedicationsExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessHeart()
    {
        return $this->hasIllnessHeart;
    }

    /**
     * @param bool $hasIllnessHeart
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessHeart(bool $hasIllnessHeart)
    {
        $this->hasIllnessHeart = $hasIllnessHeart;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessNervousSystem()
    {
        return $this->hasIllnessNervousSystem;
    }

    /**
     * @param bool $hasIllnessNervousSystem
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessNervousSystem(bool $hasIllnessNervousSystem)
    {
        $this->hasIllnessNervousSystem = $hasIllnessNervousSystem;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessColitis()
    {
        return $this->hasIllnessColitis;
    }

    /**
     * @param bool $hasIllnessColitis
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessColitis(bool $hasIllnessColitis)
    {
        $this->hasIllnessColitis = $hasIllnessColitis;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessDiabetes()
    {
        return $this->hasIllnessDiabetes;
    }

    /**
     * @param bool $hasIllnessDiabetes
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessDiabetes(bool $hasIllnessDiabetes)
    {
        $this->hasIllnessDiabetes = $hasIllnessDiabetes;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessParalysis()
    {
        return $this->hasIllnessParalysis;
    }

    /**
     * @param bool $hasIllnessParalysis
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessParalysis(bool $hasIllnessParalysis)
    {
        $this->hasIllnessParalysis = $hasIllnessParalysis;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessOthers()
    {
        return $this->hasIllnessOthers;
    }

    /**
     * @param bool $hasIllnessOthers
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessOthers(bool $hasIllnessOthers)
    {
        $this->hasIllnessOthers = $hasIllnessOthers;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessKidneys()
    {
        return $this->hasIllnessKidneys;
    }

    /**
     * @param bool $hasIllnessKidneys
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessKidneys(bool $hasIllnessKidneys)
    {
        $this->hasIllnessKidneys = $hasIllnessKidneys;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessCancer()
    {
        return $this->hasIllnessCancer;
    }

    /**
     * @param bool $hasIllnessCancer
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessCancer(bool $hasIllnessCancer)
    {
        $this->hasIllnessCancer = $hasIllnessCancer;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessHypertension()
    {
        return $this->hasIllnessHypertension;
    }

    /**
     * @param bool $hasIllnessHypertension
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessHypertension(bool $hasIllnessHypertension)
    {
        $this->hasIllnessHypertension = $hasIllnessHypertension;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessHepatitis()
    {
        return $this->hasIllnessHepatitis;
    }

    /**
     * @param bool $hasIllnessHepatitis
     * @return ApplicationFormHealthBasic
     */
    public function setHasIllnessHepatitis(bool $hasIllnessHepatitis)
    {
        $this->hasIllnessHepatitis = $hasIllnessHepatitis;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasReceivedDisabilitiesPayment()
    {
        return $this->hasReceivedDisabilitiesPayment;
    }

    /**
     * @param bool $hasReceivedDisabilitiesPayment
     * @return ApplicationFormHealthBasic
     */
    public function setHasReceivedDisabilitiesPayment(bool $hasReceivedDisabilitiesPayment)
    {
        $this->hasReceivedDisabilitiesPayment = $hasReceivedDisabilitiesPayment;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasReceivedDisabilitiesPaymentExplanation()
    {
        return $this->hasReceivedDisabilitiesPaymentExplanation;
    }

    /**
     * @param string $hasReceivedDisabilitiesPaymentExplanation
     * @return ApplicationFormHealthBasic
     */
    public function setHasReceivedDisabilitiesPaymentExplanation(string $hasReceivedDisabilitiesPaymentExplanation)
    {
        $this->hasReceivedDisabilitiesPaymentExplanation = $hasReceivedDisabilitiesPaymentExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasDeclinedApplicationForInsurance()
    {
        return $this->hasDeclinedApplicationForInsurance;
    }

    /**
     * @param bool $hasDeclinedApplicationForInsurance
     * @return ApplicationFormHealthBasic
     */
    public function setHasDeclinedApplicationForInsurance(bool $hasDeclinedApplicationForInsurance)
    {
        $this->hasDeclinedApplicationForInsurance = $hasDeclinedApplicationForInsurance;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasDeclinedApplicationForInsuranceExplanation()
    {
        return $this->hasDeclinedApplicationForInsuranceExplanation;
    }

    /**
     * @param string $hasDeclinedApplicationForInsuranceExplanation
     * @return ApplicationFormHealthBasic
     */
    public function setHasDeclinedApplicationForInsuranceExplanation(string $hasDeclinedApplicationForInsuranceExplanation)
    {
        $this->hasDeclinedApplicationForInsuranceExplanation = $hasDeclinedApplicationForInsuranceExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalGuaranteesExplanation()
    {
        return $this->additionalGuaranteesExplanation;
    }

    /**
     * @param string $additionalGuaranteesExplanation
     * @return ApplicationFormHealthBasic
     */
    public function setAdditionalGuaranteesExplanation(string $additionalGuaranteesExplanation)
    {
        $this->additionalGuaranteesExplanation = $additionalGuaranteesExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalGuaranteesNameTitle()
    {
        return $this->additionalGuaranteesNameTitle;
    }

    /**
     * @param string $additionalGuaranteesNameTitle
     * @return ApplicationFormHealthBasic
     */
    public function setAdditionalGuaranteesNameTitle(string $additionalGuaranteesNameTitle)
    {
        $this->additionalGuaranteesNameTitle = $additionalGuaranteesNameTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalGuaranteesBeforeTitle()
    {
        return $this->additionalGuaranteesBeforeTitle;
    }

    /**
     * @param string $additionalGuaranteesBeforeTitle
     * @return ApplicationFormHealthBasic
     */
    public function setAdditionalGuaranteesBeforeTitle(string $additionalGuaranteesBeforeTitle)
    {
        $this->additionalGuaranteesBeforeTitle = $additionalGuaranteesBeforeTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalGuaranteesPercentTitle()
    {
        return $this->additionalGuaranteesPercentTitle;
    }

    /**
     * @param string $additionalGuaranteesPercentTitle
     * @return ApplicationFormHealthBasic
     */
    public function setAdditionalGuaranteesPercentTitle(string $additionalGuaranteesPercentTitle)
    {
        $this->additionalGuaranteesPercentTitle = $additionalGuaranteesPercentTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalGuaranteesAfterTitle()
    {
        return $this->additionalGuaranteesAfterTitle;
    }

    /**
     * @param string $additionalGuaranteesAfterTitle
     * @return ApplicationFormHealthBasic
     */
    public function setAdditionalGuaranteesAfterTitle(string $additionalGuaranteesAfterTitle)
    {
        $this->additionalGuaranteesAfterTitle = $additionalGuaranteesAfterTitle;
        return $this;
    }

    /**
     * @return array
     */
    public function getAdditionalGuaranteesTableRows()
    {
        return $this->additionalGuaranteesTableRows;
    }

    /**
     * @param array $additionalGuaranteesTableRows
     * @return ApplicationFormHealthBasic
     */
    public function setAdditionalGuaranteesTableRows(array $additionalGuaranteesTableRows)
    {
        $this->additionalGuaranteesTableRows = $additionalGuaranteesTableRows;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAdditionalGuarantees()
    {
        $feeBefore = $this->getAdditionalGuaranteesBeforeTitle();
        $feePercent = $this->getAdditionalGuaranteesPercentTitle();
        $feeAfter = $this->getAdditionalGuaranteesAfterTitle();
        $feeRows = $this->getAdditionalGuaranteesTableRows();

        return
            null !== $feeBefore && '' !== $feeBefore &&
            null !== $feePercent && '' !== $feePercent &&
            null !== $feeAfter && '' !== $feeAfter &&
            null !== $feeRows && 0 < count($feeRows)
        ;
    }
}
