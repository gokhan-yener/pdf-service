<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Sürprim Teminat Tablosu Satırı",
 *   type="object"
 * )
 */
class HealthAdditionalGuaranteesTableRow
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Teminat İsmi", example="Vefat Teminatı")
     */
    private $name;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Uygulama Öncesi", example="1.000 TL")
     */
    private $feeBefore;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Oranı", example="%10")
     */
    private $feePercent;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=255, description="Sürprim Sonrası (Prim Artışı, Teminat Azalışı)", example="1.000 TL")
     */
    private $feeAfter;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return HealthAdditionalGuaranteesTableRow
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeeBefore()
    {
        return $this->feeBefore;
    }

    /**
     * @param string $feeBefore
     * @return HealthAdditionalGuaranteesTableRow
     */
    public function setFeeBefore(string $feeBefore)
    {
        $this->feeBefore = $feeBefore;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeePercent()
    {
        return $this->feePercent;
    }

    /**
     * @param string $feePercent
     * @return HealthAdditionalGuaranteesTableRow
     */
    public function setFeePercent(string $feePercent)
    {
        $this->feePercent = $feePercent;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeeAfter()
    {
        return $this->feeAfter;
    }

    /**
     * @param string $feeAfter
     * @return HealthAdditionalGuaranteesTableRow
     */
    public function setFeeAfter(string $feeAfter)
    {
        $this->feeAfter = $feeAfter;
        return $this;
    }
}
