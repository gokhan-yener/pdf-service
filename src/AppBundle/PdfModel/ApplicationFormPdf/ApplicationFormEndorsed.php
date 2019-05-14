<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Lehdar",
 *   type="object"
 * )
 */
class ApplicationFormEndorsed
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Ad Soyad", example="John Doe")
     */
    private $name;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=11, description="TCKN", example="12345678901")
     */
    private $personalIdNumber;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=3, description="Oranı (%)", example="10")
     */
    private $percent;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ApplicationFormEndorsed
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalIdNumber()
    {
        return $this->personalIdNumber;
    }

    /**
     * @param string $personalIdNumber
     * @return ApplicationFormEndorsed
     */
    public function setPersonalIdNumber(string $personalIdNumber)
    {
        $this->personalIdNumber = $personalIdNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * @param string $percent
     * @return ApplicationFormEndorsed
     */
    public function setPercent(string $percent)
    {
        $this->percent = $percent;
        return $this;
    }
}
