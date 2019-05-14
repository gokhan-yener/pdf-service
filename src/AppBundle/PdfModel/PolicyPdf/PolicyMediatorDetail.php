<?php

namespace AppBundle\PdfModel\PolicyPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Poliçe Aracı Bilgileri Detayı",
 *   type="object"
 * )
 */
class PolicyMediatorDetail
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Detay Tanımı (Acente, Acente Adı, HAYMER Tarife Kodu vs. gibi)", example="HAYMER Tarife Kodu")
     */
    private $label;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Detay Bilgisi", example="1234567890")
     */
    private $detail;

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return PolicyMediatorDetail
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     * @return PolicyMediatorDetail
     */
    public function setDetail(string $detail)
    {
        $this->detail = $detail;
        return $this;
    }
}
