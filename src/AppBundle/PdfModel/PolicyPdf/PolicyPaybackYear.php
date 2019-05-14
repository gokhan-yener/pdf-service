<?php

namespace AppBundle\PdfModel\PolicyPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Poliçe Geri Ödeme Yılı (sadece Eğitim İçin HS içindir)",
 *   type="object"
 * )
 */
class PolicyPaybackYear
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=4, maxLength=4, description="Geri Ödeme Yılı", example="2025")
     */
    private $year;

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return PolicyPaybackYear
     */
    public function setYear(string $year)
    {
        $this->year = $year;
        return $this;
    }
}
