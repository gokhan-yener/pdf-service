<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Yaşam Tarzı",
 *   type="object"
 * )
 */
class ApplicationFormLifestyle
{
    const DRINKING_PERIOD_DAILY = 'Günlük';
    const DRINKING_PERIOD_WEEKLY = 'Haftalık';
    const DRINKING_PERIOD_MONTHLY = 'Aylık';

    const ARMY_STATUS_EXEMPTED = 'Muaf';
    const ARMY_STATUS_DELAYED = 'Tecilli';
    const ARMY_STATUS_NOTYET = 'Zamanı gelmedi';

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=1024, description="Sağlık Beyan Metni", example="Hayat sigortası için yaptığım başvuru tarihi itibarıyla; ...")
     */
    private $healthDeclaration;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Sigara kullanıyor musunuz?")
     */
    private $isSmoking;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=3, description="Günlük içtiğiniz sigara adedi", example="20")
     */
    private $numSmokingPerDay;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Alkol kullanıyor musunuz?")
     */
    private $isDrinking;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", description="Alkol kullanım sıklığı", minLength=1, maxLength=64, example="1 Kadeh")
     */
    private $drinkingPeriod;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Herhangi bir tehlikeli aktivite ...")
     */
    private $isDoingExtremeSports;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=1024, description="Tehlikeli aktivite (açıklama)", example="Dağcılık vs.")
     */
    private $extremeSportsExplanation;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Askerlik sorusu sorulduysa true olması gerek")
     */
    private $isArmyAsked;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Askerlik yaptınız mı?")
     */
    private $wasAtArmy;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", description="Askerlik yapılmadı (sebebi)", minLength=1, maxLength=16, example="Muaf", enum={"Muaf", "Tecilli", "Zamanı gelmedi"})
     */
    private $armyStatus;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=1024, description="Askerlik yapılmadı (açıklama)", example="Askerlik yapmadım çünkü...")
     */
    private $armyExplanation;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=10, description="Boy", example="1 m 75 cm")
     */
    private $height;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=10, description="Kilo", example="70 kg")
     */
    private $weight;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=10, description="Eğitim Durumunuz", example="Yüksek Lisans")
     */
    private $education;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=10, description="Mesleğiniz", example="Avukat")
     */
    private $profession;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Türkiye dışına seyahat sorulduysa true olması gerek")
     */
    private $isTravellingAsked;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Türkiye dışına seyahat ...")
     */
    private $isTravelling;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=0, maxLength=1024, description="Seyahat (ülkeler)", example="Norveç, Almanya")
     */
    private $travellingCountries;

    /**
     * @return string
     */
    public function getHealthDeclaration()
    {
        return $this->healthDeclaration;
    }

    /**
     * @param string $healthDeclaration
     * @return ApplicationFormLifestyle
     */
    public function setHealthDeclaration(string $healthDeclaration)
    {
        $this->healthDeclaration = $healthDeclaration;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSmoking()
    {
        return $this->isSmoking;
    }

    /**
     * @param bool $isSmoking
     * @return ApplicationFormLifestyle
     */
    public function setIsSmoking(bool $isSmoking)
    {
        $this->isSmoking = $isSmoking;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumSmokingPerDay()
    {
        return $this->numSmokingPerDay;
    }

    /**
     * @param string $numSmokingPerDay
     * @return ApplicationFormLifestyle
     */
    public function setNumSmokingPerDay(string $numSmokingPerDay)
    {
        $this->numSmokingPerDay = $numSmokingPerDay;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDrinking()
    {
        return $this->isDrinking;
    }

    /**
     * @param bool $isDrinking
     * @return ApplicationFormLifestyle
     */
    public function setIsDrinking(bool $isDrinking)
    {
        $this->isDrinking = $isDrinking;
        return $this;
    }

    /**
     * @return string
     */
    public function getDrinkingPeriod()
    {
        return $this->drinkingPeriod;
    }

    /**
     * @param string $drinkingPeriod
     * @return ApplicationFormLifestyle
     */
    public function setDrinkingPeriod(string $drinkingPeriod)
    {
        $this->drinkingPeriod = $drinkingPeriod;
        return $this;
    }

    /**
     * @return string
     */
    public function getDrinkingPeriodSlug()
    {
        $periods = [
            self::DRINKING_PERIOD_DAILY => 'Daily',
            self::DRINKING_PERIOD_WEEKLY => 'Weekly',
            self::DRINKING_PERIOD_MONTHLY => 'Monthly',
        ];

        $period = $this->getDrinkingPeriod();

        return $periods[$period] ?? '';
    }

    /**
     * @return bool
     */
    public function getIsDoingExtremeSports()
    {
        return $this->isDoingExtremeSports;
    }

    /**
     * @param bool $isDoingExtremeSports
     * @return ApplicationFormLifestyle
     */
    public function setIsDoingExtremeSports(bool $isDoingExtremeSports)
    {
        $this->isDoingExtremeSports = $isDoingExtremeSports;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtremeSportsExplanation()
    {
        return $this->extremeSportsExplanation;
    }

    /**
     * @param string $extremeSportsExplanation
     * @return ApplicationFormLifestyle
     */
    public function setExtremeSportsExplanation(string $extremeSportsExplanation)
    {
        $this->extremeSportsExplanation = $extremeSportsExplanation;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsArmyAsked()
    {
        return $this->isArmyAsked;
    }

    /**
     * @param bool $isArmyAsked
     */
    public function setIsArmyAsked(bool $isArmyAsked)
    {
        $this->isArmyAsked = $isArmyAsked;
    }

    /**
     * @return bool
     */
    public function getWasAtArmy()
    {
        return $this->wasAtArmy;
    }

    /**
     * @param bool $wasAtArmy
     * @return ApplicationFormLifestyle
     */
    public function setWasAtArmy(bool $wasAtArmy)
    {
        $this->wasAtArmy = $wasAtArmy;
        return $this;
    }

    /**
     * @return string
     */
    public function getArmyStatus()
    {
        return $this->armyStatus;
    }

    /**
     * @return string
     */
    public function getArmyStatusSlug()
    {
        $statuses = [
            self::ARMY_STATUS_EXEMPTED => 'Exempted',
            self::ARMY_STATUS_DELAYED => 'Delayed',
            self::ARMY_STATUS_NOTYET => 'NotYetTheTime',
        ];

        $status = $this->getArmyStatus();

        return $statuses[$status] ?? '';
    }

    /**
     * @param string $armyStatus
     * @return ApplicationFormLifestyle
     */
    public function setArmyStatus(string $armyStatus)
    {
        $this->armyStatus = $armyStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getArmyExplanation()
    {
        return $this->armyExplanation;
    }

    /**
     * @param string $armyExplanation
     * @return ApplicationFormLifestyle
     */
    public function setArmyExplanation(string $armyExplanation)
    {
        $this->armyExplanation = $armyExplanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $height
     * @return ApplicationFormLifestyle
     */
    public function setHeight(string $height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     * @return ApplicationFormLifestyle
     */
    public function setWeight(string $weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @param string $education
     * @return ApplicationFormLifestyle
     */
    public function setEducation(string $education)
    {
        $this->education = $education;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param string $profession
     * @return ApplicationFormLifestyle
     */
    public function setProfession(string $profession)
    {
        $this->profession = $profession;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTravellingAsked()
    {
        return $this->isTravellingAsked;
    }

    /**
     * @param bool $isTravellingAsked
     * @return ApplicationFormLifestyle
     */
    public function setIsTravellingAsked(bool $isTravellingAsked)
    {
        $this->isTravellingAsked = $isTravellingAsked;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsTravelling()
    {
        return $this->isTravelling;
    }

    /**
     * @param string $isTravelling
     * @return ApplicationFormLifestyle
     */
    public function setIsTravelling(string $isTravelling)
    {
        $this->isTravelling = $isTravelling;
        return $this;
    }

    /**
     * @return string
     */
    public function getTravellingCountries()
    {
        return $this->travellingCountries;
    }

    /**
     * @param string $travellingCountries
     * @return ApplicationFormLifestyle
     */
    public function setTravellingCountries(string $travellingCountries)
    {
        $this->travellingCountries = $travellingCountries;
        return $this;
    }
}
