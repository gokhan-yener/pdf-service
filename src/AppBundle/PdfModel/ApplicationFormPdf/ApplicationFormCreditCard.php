<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Kredi Kartı",
 *   type="object"
 * )
 */
class ApplicationFormCreditCard
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Banka İsmi", example="Örnek Bankası")
     */
    private $bankName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="Kredi Kartı No", example="1234567812345678")
     */
    private $number;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Kredi Kartı Bitiş Tarihi", example="01/23")
     */
    private $expirationDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Kredi Kartı Sahibi", example="John Doe")
     */
    private $ownerName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Kredi Kartı Türü (Master, Visa)", example="Master")
     */
    private $type;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="Öncelikle bu kartı kullan")
     */
    private $isPreferred;

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @param string $bankName
     * @return ApplicationFormCreditCard
     */
    public function setBankName(string $bankName)
    {
        $this->bankName = $bankName;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return ApplicationFormCreditCard
     */
    public function setNumber(string $number)
    {
        $this->number = $number;
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
     * @return ApplicationFormCreditCard
     */
    public function setExpirationDate(string $expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwnerName()
    {
        return $this->ownerName;
    }

    /**
     * @param string $ownerName
     * @return ApplicationFormCreditCard
     */
    public function setOwnerName(string $ownerName)
    {
        $this->ownerName = $ownerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ApplicationFormCreditCard
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsPreferred()
    {
        return $this->isPreferred;
    }

    /**
     * @param bool $isPreferred
     * @return ApplicationFormCreditCard
     */
    public function setIsPreferred(bool $isPreferred)
    {
        $this->isPreferred = $isPreferred;
        return $this;
    }
}
