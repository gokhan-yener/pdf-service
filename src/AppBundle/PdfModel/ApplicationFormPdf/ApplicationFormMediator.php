<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Aracı Bilgileri",
 *   type="object"
 * )
 */
class ApplicationFormMediator
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Aracı Şirket Türü", example="Acente", enum={"Acente", "Şube", "Bölge"})
     */
    private $companyType;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Aracı Şirket Adı", example="Örnek Sigorta Acentesi Lt.d")
     */
    private $companyName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Aracı Şahıs Türü", example="Aracı", enum={"Aracı", "Finansal Güvence Danışmanı"})
     */
    private $personType;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Aracı Şahıs Adı", example="John Doe")
     */
    private $personName;

    /**
     * @return string
     */
    public function getCompanyType()
    {
        return $this->companyType;
    }

    /**
     * @param string $companyType
     * @return ApplicationFormMediator
     */
    public function setCompanyType(string $companyType)
    {
        $this->companyType = $companyType;
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
     * @return ApplicationFormMediator
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonType()
    {
        return $this->personType;
    }

    /**
     * @param string $personType
     * @return ApplicationFormMediator
     */
    public function setPersonType(string $personType)
    {
        $this->personType = $personType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }

    /**
     * @param string $personName
     * @return ApplicationFormMediator
     */
    public function setPersonName(string $personName)
    {
        $this->personName = $personName;
        return $this;
    }
}
