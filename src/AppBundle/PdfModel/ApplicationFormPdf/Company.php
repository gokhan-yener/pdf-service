<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Şirket",
 *   type="object"
 * )
 */
trait Company
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Ünvan", example="Örnek Şirketi Ltd.")
     */
    private $title;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Sektör", example="E-Ticaret")
     */
    private $sector;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="Tic. Sicil No / Mersis No", example="1234567890")
     */
    private $registrationNumber;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Faaliyet Konusu", example="Ürün alım satım")
     */
    private $activity;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Vergi Dairesi", example="Üsküdar")
     */
    private $taxAdministration;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Vergi No", example="1234567890")
     */
    private $taxId;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Telefon", example="0 (216) 666 66 66")
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
     * @SWG\Property(type="string", format="email", minLength=1, maxLength=255, description="E-Posta", example="info@example.com")
     */
    private $emailAddress;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=255, description="Web Sitesi", example="http://www.example.com")
     */
    private $website;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Adres", example="Örnek Mah. Örnek Sok. No 5 Üsküdar-İstanbul")
     */
    private $address;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Company
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * @param string $sector
     * @return Company
     */
    public function setSector(string $sector)
    {
        $this->sector = $sector;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }

    /**
     * @param string $registrationNumber
     * @return Company
     */
    public function setRegistrationNumber(string $registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     * @return Company
     */
    public function setActivity(string $activity)
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxAdministration()
    {
        return $this->taxAdministration;
    }

    /**
     * @param string $taxAdministration
     * @return Company
     */
    public function setTaxAdministration(string $taxAdministration)
    {
        $this->taxAdministration = $taxAdministration;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * @param string $taxId
     * @return Company
     */
    public function setTaxId(string $taxId)
    {
        $this->taxId = $taxId;
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
     * @return Company
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
     * @return Company
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
     * @return Company
     */
    public function setEmailAddress(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Company
     */
    public function setWebsite(string $website)
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Company
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }
}
