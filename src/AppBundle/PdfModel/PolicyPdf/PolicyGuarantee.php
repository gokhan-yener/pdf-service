<?php

namespace AppBundle\PdfModel\PolicyPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Poliçe Teminatı",
 *   type="object"
 * )
 */
class PolicyGuarantee
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Teminat", example="Vefat Teminatı")
     */
    private $title;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Teminat Tutarı", example="3.000")
     */
    private $price;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Hak Sahibi", example="Hak Sahipleri Bölümüne Bakınız")
     */
    private $endorsed;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PolicyGuarantee
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return PolicyGuarantee
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndorsed()
    {
        return $this->endorsed;
    }

    /**
     * @param string $endorsed
     * @return PolicyGuarantee
     */
    public function setEndorsed(string $endorsed)
    {
        $this->endorsed = $endorsed;
        return $this;
    }
}
