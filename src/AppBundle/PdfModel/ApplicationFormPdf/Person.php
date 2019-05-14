<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Şahıs",
 *   type="object"
 * )
 */
trait Person
{
    /**
     * @var array
     * @JMS\Exclude()
     */
    private $genders = [
        'male' => 'E',
        'female' => 'K',
    ];

    /**
     * @var array
     * @JMS\Exclude()
     */
    private $postalAddresses = [
        'home' => 'Ev',
        'work' => 'İş',
    ];

    /**
     * @var array
     * @JMS\Exclude()
     */
    private $notificationForms = [
        'mail' => 'E-Posta',
        'sms' => 'SMS',
    ];

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=11, maxLength=11, description="TC Kimlik No", example="12345678912")
     */
    private $personalIdNumber;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Soyadı", example="Doe")
     */
    private $lastName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Adı", example="John")
     */
    private $firstName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Doğum Tarihi", example="01/01/1980")
     */
    private $birthDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Kimlik Seri No", example="A3568Z5460")
     */
    private $serialNumber;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Kimlik Geçerlilik Tarihi", example="01/01/2019")
     */
    private $expirationDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=1, description="Cinsiyet", example="E", enum={"E", "K"})
     */
    private $gender;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Uyruğu", example="TC")
     */
    private $nationality;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Anne Adı", example="Jane")
     */
    private $mothersName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Baba Adı", example="John")
     */
    private $fathersName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Eğitim Durumu", example="Lise")
     */
    private $education;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Meslek / Sektör", example="Muhasebeci")
     */
    private $profession;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="TIN No (ABD)", example="1234567890")
     */
    private $usaTinNumber;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Telefon", example="0 (216) 555 55 55")
     */
    private $phoneNumber;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Cep Telefonu", example="0 (555) 555 55 55")
     */
    private $phoneNumberMobile;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="email", minLength=1, maxLength=255, description="E-Posta", example="john@example.com")
     */
    private $emailAddress;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Ev Adresi", example="Örnek Mah. Örnek Sok. No 5 Üsküdar-İstanbul")
     */
    private $addressHome;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="İş Adresi", example="Örnek Mah. Örnek Sok. No 5 Üsküdar-İstanbul")
     */
    private $addressWork;

    /**
     * @return string
     */
    public function getPersonalIdNumber()
    {
        return $this->personalIdNumber;
    }

    /**
     * @param string $personalIdNumber
     * @return Person
     */
    public function setPersonalIdNumber(string $personalIdNumber)
    {
        $this->personalIdNumber = $personalIdNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Person
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Person
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     * @return Person
     */
    public function setBirthDate(string $birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     * @return Person
     */
    public function setSerialNumber(string $serialNumber)
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param string $expirationDate
     * @return Person
     */
    public function setExpirationDate(string $expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Person
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     * @return Person
     */
    public function setNationality(string $nationality)
    {
        $this->nationality = $nationality;
        return $this;
    }

    /**
     * @return string
     */
    public function getMothersName()
    {
        return $this->mothersName;
    }

    /**
     * @param string $mothersName
     * @return Person
     */
    public function setMothersName(string $mothersName)
    {
        $this->mothersName = $mothersName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFathersName()
    {
        return $this->fathersName;
    }

    /**
     * @param string $fathersName
     * @return Person
     */
    public function setFathersName(string $fathersName)
    {
        $this->fathersName = $fathersName;
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
     * @return Person
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
     * @return Person
     */
    public function setProfession(string $profession)
    {
        $this->profession = $profession;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsaTinNumber()
    {
        return $this->usaTinNumber;
    }

    /**
     * @param string $usaTinNumber
     * @return Person
     */
    public function setUsaTinNumber(string $usaTinNumber)
    {
        $this->usaTinNumber = $usaTinNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return Person
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumberMobile()
    {
        return $this->phoneNumberMobile;
    }

    /**
     * @param string $phoneNumberMobile
     * @return Person
     */
    public function setPhoneNumberMobile(string $phoneNumberMobile)
    {
        $this->phoneNumberMobile = $phoneNumberMobile;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     * @return Person
     */
    public function setEmailAddress(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressHome()
    {
        return $this->addressHome;
    }

    /**
     * @param string $addressHome
     * @return Person
     */
    public function setAddressHome(string $addressHome)
    {
        $this->addressHome = $addressHome;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressWork()
    {
        return $this->addressWork;
    }

    /**
     * @param string $addressWork
     * @return Person
     */
    public function setAddressWork(string $addressWork)
    {
        $this->addressWork = $addressWork;
        return $this;
    }
}
