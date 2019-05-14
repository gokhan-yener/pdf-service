<?php

namespace AppBundle\PdfModel\PolicyPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Poliçe: Lehdar",
 *   type="object"
 * )
 */
class PolicyEndorsed
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
     * @return PolicyEndorsed
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     * @return PolicyEndorsed
     */
    public function setPercent(string $percent)
    {
        $this->percent = $percent;
        return $this;
    }
}
