<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Sağlık Bilgileri (12 Soru)",
 *   type="object"
 * )
 */
class ApplicationFormHealthExtended
{
    const VISIT_TYPE_ROUTINELY = 'Rutin Kontroller';
    const VISIT_TYPE_OTHER = 'Diğer';

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Şu an itibariyle bir sağlık probleminiz, doformasyona uğrayan ...")
     */
    private $hasChronicIllness;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama (sağlık probleminiz, deformasyon)", example="Sağ kolumda deformasyon var ...")
     */
    private $hasChronicIllnessExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Aşağıdaki hastalıklardan herhangi birini geçirdiniz mi ...")
     */
    private $hasAnyIllnessBelow;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Dolaşım sistemi hastalıkları ...")
     */
    private $hasIllnessCardiovascular;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama - Dolaşım sistemi hastalıkları ...")
     */
    private $hasIllnessCardiovascularExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Solunum sistemi hastalıkları ...")
     */
    private $hasIllnessRespiratory;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama - Solunum sistemi hastalıkları...")
     */
    private $hasIllnessRespiratoryExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Genitoüriner sistem hastalıkları ...")
     */
    private $hasIllnessGenitourinary;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama - Genitoüriner sistem hastalıkları...")
     */
    private $hasIllnessGenitourinaryExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Genitoüriner - Böbrek taşı")
     */
    private $hasIllnessKidneyStone;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Genitoüriner - Diğer")
     */
    private $hasIllnessGenitourinaryOther;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Sindirim sistemi hastalıkları ...")
     */
    private $hasIllnessDigestive;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Diğer - Sindirim sistemi hastalıkları ...")
     */
    private $hasIllnessDigestiveOther;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama - Sindirim sistemi hastalıkları...")
     */
    private $hasIllnessDigestiveExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Taş sebebi ile safra kesesi alındı")
     */
    private $hasGallbladderRemoved;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Sinir sistemi hastalıkları ...")
     */
    private $hasIllnessNervous;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama - Sinir sistemi hastalıkları...")
     */
    private $hasIllnessNervousExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Diyabet, kanser, ... tiroid gibi bez hastalıkları")
     */
    private $hasIllnessGland;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama - Diyabet, kanser, ... tiroid gibi bez hastalıkları...")
     */
    private $hasIllnessGlandExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Açıklanamayan gece terlemesi ...")
     */
    private $hasIllnessUnexplainable;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama - Açıklanamayan gece terlemesi...")
     */
    private $hasIllnessUnexplainableExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Yukarıda yer almayan herhangi bir diğer hastalık ...")
     */
    private $hasIllnessOther;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=1024, description="Açıklama (herhangi bir diğer hastalık)", example="Diğer hastalıklar listesi ...")
     */
    private $hasIllnessOtherExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Daha önce hiç hastane tedavisi geçirdiniz mi ...")
     */
    private $wasAtHospital;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama (hastane tedavisi, ameliyat)", example="Geçen sene ameliyat olmuştum ...")
     */
    private $wasAtHospitalExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Daha önce hiç aids ya da aids ile ilişkili ...")
     */
    private $hasHivSuspicion;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama (AIDS)", example="AIDS için kan testi yaptırmıştım ...")
     */
    private $hasHivSuspicionExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Son 5 yıl içinde kontroller ve kan testleri de dahil ... doktora başvurdunuz mu?")
     */
    private $hasVisitedPhysician;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=3, description="Doktora Başvuru Sebebi", example="Rutin Kontroller", enum={"Rutin Kontroller", "Diğer"})
     */
    private $visitType;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Son 5 yıl içinde size kan nakli yapıldı mı?")
     */
    private $hasReceivedBloodTransfusion;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama (kan nakli)", example="Ameliyat olduğumda kan nakli yapılmıştı ...")
     */
    private $hasReceivedBloodTransfusionExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Daha önce hiç maluliyet ödemesi aldınız mı ...")
     */
    private $hasReceivedDisabilityPayments;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama (maluliyet ödemesi)", example="5 yıldır maluliyet ödemesi alıyorum ...")
     */
    private $hasReceivedDisabilityPaymentsExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Geçici veya kalıcı felç ...")
     */
    private $hasParalysis;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama (felç)", example="Geçici felç yaşadım ...")
     */
    private $hasParalysisExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Herhangi bir organ veya doku nakli ...")
     */
    private $hasTransplantation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Açıklama (organ nakli)", example="Organ veya doku nakli ...")
     */
    private $hasTransplantationExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Yukarıda yer alan hastalıklara benzer ... akrabanız var mı?")
     */
    private $hasSimilarProblems;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=1024, description="Açıklama (Yukarıda yer alan hastalıklara benzer ... akrabanız)", example="Babam geçici felç geçirdi ...")
     */
    private $hasSimilarProblemsExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Daha önce reddedilen ... başvurunuz ... oldu mu?")
     */
    private $hasRejectedInsurance;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, example="1 yıl önce de başvurmuşttum, kabul edilmedi")
     */
    private $hasRejectedInsuranceExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Son 12 ay içerisinde ... 10 günden fazla işe devamsızlık ...")
     */
    private $hasNotificationOfIllness;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, example="Ameliyat sonrası 15 gün işe devam edemedim ...")
     */
    private $hasNotificationOfIllnessExplanation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=1024, description="Sürprim Teminat Tablosu Açıklaması", example="Başvurunuza istinaden yapılan ön değerlendirme sonuçları ...")
     */
    private $additionalGuaranteesExplanation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Teminat Tablosu (1. Başlık): Teminat İsmi", example="Vefat Teminatı")
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
    public function getHasChronicIllness()
    {
        return $this->hasChronicIllness;
    }

    /**
     * @param bool $hasChronicIllness
     * @return ApplicationFormHealthExtended
     */
    public function setHasChronicIllness(bool $hasChronicIllness)
    {
        $this->hasChronicIllness = $hasChronicIllness;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasChronicIllnessExplanation()
    {
        return $this->hasChronicIllnessExplanation;
    }

    /**
     * @param string $hasChronicIllnessExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasChronicIllnessExplanation(string $hasChronicIllnessExplanation)
    {
        $this->hasChronicIllnessExplanation = $hasChronicIllnessExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasAnyIllnessBelow()
    {
        return $this->hasAnyIllnessBelow;
    }

    /**
     * @param bool $hasAnyIllnessBelow
     * @return ApplicationFormHealthExtended
     */
    public function setHasAnyIllnessBelow(bool $hasAnyIllnessBelow)
    {
        $this->hasAnyIllnessBelow = $hasAnyIllnessBelow;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessCardiovascular()
    {
        return $this->hasIllnessCardiovascular;
    }

    /**
     * @param bool $hasIllnessCardiovascular
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessCardiovascular(bool $hasIllnessCardiovascular)
    {
        $this->hasIllnessCardiovascular = $hasIllnessCardiovascular;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasIllnessCardiovascularExplanation(): string
    {
        return $this->hasIllnessCardiovascularExplanation;
    }

    /**
     * @return bool
     */
    public function getHasIllnessDigestiveOther(): bool
    {
        return $this->hasIllnessDigestiveOther;
    }

    /**
     * @param bool $hasIllnessDigestiveOther
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessDigestiveOther(bool $hasIllnessDigestiveOther)
    {
        $this->hasIllnessDigestiveOther = $hasIllnessDigestiveOther;
        return $this;
    }

    /**
     * @param string $hasIllnessCardiovascularExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessCardiovascularExplanation(string $hasIllnessCardiovascularExplanation)
    {
        $this->hasIllnessCardiovascularExplanation = $hasIllnessCardiovascularExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasIllnessRespiratoryExplanation(): string
    {
        return $this->hasIllnessRespiratoryExplanation;
    }

    /**
     * @param string $hasIllnessRespiratoryExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessRespiratoryExplanation(string $hasIllnessRespiratoryExplanation)
    {
        $this->hasIllnessRespiratoryExplanation = $hasIllnessRespiratoryExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasIllnessGenitourinaryExplanation(): string
    {
        return $this->hasIllnessGenitourinaryExplanation;
    }

    /**
     * @param string $hasIllnessGenitourinaryExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessGenitourinaryExplanation(string $hasIllnessGenitourinaryExplanation)
    {
        $this->hasIllnessGenitourinaryExplanation = $hasIllnessGenitourinaryExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasIllnessDigestiveExplanation(): string
    {
        return $this->hasIllnessDigestiveExplanation;
    }

    /**
     * @param string $hasIllnessDigestiveExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessDigestiveExplanation(string $hasIllnessDigestiveExplanation)
    {
        $this->hasIllnessDigestiveExplanation = $hasIllnessDigestiveExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasIllnessNervousExplanation(): string
    {
        return $this->hasIllnessNervousExplanation;
    }

    /**
     * @param string $hasIllnessNervousExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessNervousExplanation(string $hasIllnessNervousExplanation)
    {
        $this->hasIllnessNervousExplanation = $hasIllnessNervousExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasIllnessGlandExplanation(): string
    {
        return $this->hasIllnessGlandExplanation;
    }

    /**
     * @param string $hasIllnessGlandExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessGlandExplanation(string $hasIllnessGlandExplanation)
    {
        $this->hasIllnessGlandExplanation = $hasIllnessGlandExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasIllnessUnexplainableExplanation(): string
    {
        return $this->hasIllnessUnexplainableExplanation;
    }

    /**
     * @param string $hasIllnessUnexplainableExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessUnexplainableExplanation(string $hasIllnessUnexplainableExplanation)
    {
        $this->hasIllnessUnexplainableExplanation = $hasIllnessUnexplainableExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessRespiratory()
    {
        return $this->hasIllnessRespiratory;
    }

    /**
     * @param bool $hasIllnessRespiratory
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessRespiratory(bool $hasIllnessRespiratory)
    {
        $this->hasIllnessRespiratory = $hasIllnessRespiratory;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessGenitourinary()
    {
        return $this->hasIllnessGenitourinary;
    }

    /**
     * @param bool $hasIllnessGenitourinary
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessGenitourinary(bool $hasIllnessGenitourinary)
    {
        $this->hasIllnessGenitourinary = $hasIllnessGenitourinary;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessKidneyStone()
    {
        return $this->hasIllnessKidneyStone;
    }

    /**
     * @param bool $hasIllnessKidneyStone
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessKidneyStone(bool $hasIllnessKidneyStone)
    {
        $this->hasIllnessKidneyStone = $hasIllnessKidneyStone;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessGenitourinaryOther()
    {
        return $this->hasIllnessGenitourinaryOther;
    }

    /**
     * @param bool $hasIllnessGenitourinaryOther
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessGenitourinaryOther(bool $hasIllnessGenitourinaryOther)
    {
        $this->hasIllnessGenitourinaryOther = $hasIllnessGenitourinaryOther;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessDigestive()
    {
        return $this->hasIllnessDigestive;
    }

    /**
     * @param bool $hasIllnessDigestive
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessDigestive(bool $hasIllnessDigestive)
    {
        $this->hasIllnessDigestive = $hasIllnessDigestive;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasGallbladderRemoved()
    {
        return $this->hasGallbladderRemoved;
    }

    /**
     * @param bool $hasGallbladderRemoved
     * @return ApplicationFormHealthExtended
     */
    public function setHasGallbladderRemoved(bool $hasGallbladderRemoved)
    {
        $this->hasGallbladderRemoved = $hasGallbladderRemoved;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessNervous()
    {
        return $this->hasIllnessNervous;
    }

    /**
     * @param bool $hasIllnessNervous
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessNervous(bool $hasIllnessNervous)
    {
        $this->hasIllnessNervous = $hasIllnessNervous;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessGland()
    {
        return $this->hasIllnessGland;
    }

    /**
     * @param bool $hasIllnessGland
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessGland(bool $hasIllnessGland)
    {
        $this->hasIllnessGland = $hasIllnessGland;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessUnexplainable()
    {
        return $this->hasIllnessUnexplainable;
    }

    /**
     * @param bool $hasIllnessUnexplainable
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessUnexplainable(bool $hasIllnessUnexplainable)
    {
        $this->hasIllnessUnexplainable = $hasIllnessUnexplainable;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessOther()
    {
        return $this->hasIllnessOther;
    }

    /**
     * @param bool $hasIllnessOther
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessOther(bool $hasIllnessOther)
    {
        $this->hasIllnessOther = $hasIllnessOther;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasIllnessOtherExplanation()
    {
        return $this->hasIllnessOtherExplanation;
    }

    /**
     * @param bool $hasIllnessOtherExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasIllnessOtherExplanation(bool $hasIllnessOtherExplanation)
    {
        $this->hasIllnessOtherExplanation = $hasIllnessOtherExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getWasAtHospital()
    {
        return $this->wasAtHospital;
    }

    /**
     * @param bool $wasAtHospital
     * @return ApplicationFormHealthExtended
     */
    public function setWasAtHospital(bool $wasAtHospital)
    {
        $this->wasAtHospital = $wasAtHospital;
        return $this;
    }

    /**
     * @return string
     */
    public function getWasAtHospitalExplanation()
    {
        return $this->wasAtHospitalExplanation;
    }

    /**
     * @param string $wasAtHospitalExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setWasAtHospitalExplanation(string $wasAtHospitalExplanation)
    {
        $this->wasAtHospitalExplanation = $wasAtHospitalExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasHivSuspicion()
    {
        return $this->hasHivSuspicion;
    }

    /**
     * @param bool $hasHivSuspicion
     * @return ApplicationFormHealthExtended
     */
    public function setHasHivSuspicion(bool $hasHivSuspicion)
    {
        $this->hasHivSuspicion = $hasHivSuspicion;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasHivSuspicionExplanation()
    {
        return $this->hasHivSuspicionExplanation;
    }

    /**
     * @param string $hasHivSuspicionExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasHivSuspicionExplanation(string $hasHivSuspicionExplanation)
    {
        $this->hasHivSuspicionExplanation = $hasHivSuspicionExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasVisitedPhysician()
    {
        return $this->hasVisitedPhysician;
    }

    /**
     * @param bool $hasVisitedPhysician
     * @return ApplicationFormHealthExtended
     */
    public function setHasVisitedPhysician(bool $hasVisitedPhysician)
    {
        $this->hasVisitedPhysician = $hasVisitedPhysician;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisitType()
    {
        return $this->visitType;
    }

    /**
     * @return string
     */
    public function getVisitTypeSlug()
    {
        $types = [
            self::VISIT_TYPE_ROUTINELY => 'Routinely',
            self::VISIT_TYPE_OTHER => 'Other',
        ];

        $type = $this->getVisitType();

        return $types[$type] ?? '';
    }

    /**
     * @param string $visitType
     * @return ApplicationFormHealthExtended
     */
    public function setVisitType(string $visitType)
    {
        $this->visitType = $visitType;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasReceivedBloodTransfusion()
    {
        return $this->hasReceivedBloodTransfusion;
    }

    /**
     * @param bool $hasReceivedBloodTransfusion
     * @return ApplicationFormHealthExtended
     */
    public function setHasReceivedBloodTransfusion(bool $hasReceivedBloodTransfusion)
    {
        $this->hasReceivedBloodTransfusion = $hasReceivedBloodTransfusion;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasReceivedBloodTransfusionExplanation()
    {
        return $this->hasReceivedBloodTransfusionExplanation;
    }

    /**
     * @param string $hasReceivedBloodTransfusionExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasReceivedBloodTransfusionExplanation(string $hasReceivedBloodTransfusionExplanation)
    {
        $this->hasReceivedBloodTransfusionExplanation = $hasReceivedBloodTransfusionExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasReceivedDisabilityPayments()
    {
        return $this->hasReceivedDisabilityPayments;
    }

    /**
     * @param bool $hasReceivedDisabilityPayments
     * @return ApplicationFormHealthExtended
     */
    public function setHasReceivedDisabilityPayments(bool $hasReceivedDisabilityPayments)
    {
        $this->hasReceivedDisabilityPayments = $hasReceivedDisabilityPayments;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasReceivedDisabilityPaymentsExplanation()
    {
        return $this->hasReceivedDisabilityPaymentsExplanation;
    }

    /**
     * @param string $hasReceivedDisabilityPaymentsExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasReceivedDisabilityPaymentsExplanation(string $hasReceivedDisabilityPaymentsExplanation)
    {
        $this->hasReceivedDisabilityPaymentsExplanation = $hasReceivedDisabilityPaymentsExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasParalysis()
    {
        return $this->hasParalysis;
    }

    /**
     * @param bool $hasParalysis
     * @return ApplicationFormHealthExtended
     */
    public function setHasParalysis(bool $hasParalysis)
    {
        $this->hasParalysis = $hasParalysis;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasParalysisExplanation()
    {
        return $this->hasParalysisExplanation;
    }

    /**
     * @param string $hasParalysisExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasParalysisExplanation(string $hasParalysisExplanation)
    {
        $this->hasParalysisExplanation = $hasParalysisExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasTransplantation()
    {
        return $this->hasTransplantation;
    }

    /**
     * @param bool $hasTransplantation
     * @return ApplicationFormHealthExtended
     */
    public function setHasTransplantation(bool $hasTransplantation)
    {
        $this->hasTransplantation = $hasTransplantation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasTransplantationExplanation()
    {
        return $this->hasTransplantationExplanation;
    }

    /**
     * @param string $hasTransplantationExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasTransplantationExplanation(string $hasTransplantationExplanation)
    {
        $this->hasTransplantationExplanation = $hasTransplantationExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasSimilarProblems()
    {
        return $this->hasSimilarProblems;
    }

    /**
     * @param bool $hasSimilarProblems
     * @return ApplicationFormHealthExtended
     */
    public function setHasSimilarProblems(bool $hasSimilarProblems)
    {
        $this->hasSimilarProblems = $hasSimilarProblems;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasSimilarProblemsExplanation()
    {
        return $this->hasSimilarProblemsExplanation;
    }

    /**
     * @param string $hasSimilarProblemsExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasSimilarProblemsExplanation(string $hasSimilarProblemsExplanation)
    {
        $this->hasSimilarProblemsExplanation = $hasSimilarProblemsExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasRejectedInsurance()
    {
        return $this->hasRejectedInsurance;
    }

    /**
     * @param bool $hasRejectedInsurance
     * @return ApplicationFormHealthExtended
     */
    public function setHasRejectedInsurance(bool $hasRejectedInsurance)
    {
        $this->hasRejectedInsurance = $hasRejectedInsurance;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasRejectedInsuranceExplanation()
    {
        return $this->hasRejectedInsuranceExplanation;
    }

    /**
     * @param string $hasRejectedInsuranceExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasRejectedInsuranceExplanation(string $hasRejectedInsuranceExplanation)
    {
        $this->hasRejectedInsuranceExplanation = $hasRejectedInsuranceExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasNotificationOfIllness()
    {
        return $this->hasNotificationOfIllness;
    }

    /**
     * @param bool $hasNotificationOfIllness
     * @return ApplicationFormHealthExtended
     */
    public function setHasNotificationOfIllness(bool $hasNotificationOfIllness)
    {
        $this->hasNotificationOfIllness = $hasNotificationOfIllness;
        return $this;
    }

    /**
     * @return string
     */
    public function getHasNotificationOfIllnessExplanation()
    {
        return $this->hasNotificationOfIllnessExplanation;
    }

    /**
     * @param string $hasNotificationOfIllnessExplanation
     * @return ApplicationFormHealthExtended
     */
    public function setHasNotificationOfIllnessExplanation(string $hasNotificationOfIllnessExplanation)
    {
        $this->hasNotificationOfIllnessExplanation = $hasNotificationOfIllnessExplanation;
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
     * @return ApplicationFormHealthExtended
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
     * @return ApplicationFormHealthExtended
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
     * @return ApplicationFormHealthExtended
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
     * @return ApplicationFormHealthExtended
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
     * @return ApplicationFormHealthExtended
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
     * @return ApplicationFormHealthExtended
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
