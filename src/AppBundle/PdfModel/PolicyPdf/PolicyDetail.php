<?php

namespace AppBundle\PdfModel\PolicyPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Poliçe Detayı",
 *   type="object"
 * )
 */
class PolicyDetail
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Detay Tanımı (Başlangıç Tarihi, Sigorta Süresi, Ödeme Dönemi vs. gibi)", example="Başlangıç Tarihi")
     */
    private $label;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Detay Bilgisi", example="01/01/2018")
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
     * @return PolicyDetail
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
     * @return PolicyDetail
     */
    public function setDetail(string $detail)
    {
        $this->detail = $detail;
        return $this;
    }
}
