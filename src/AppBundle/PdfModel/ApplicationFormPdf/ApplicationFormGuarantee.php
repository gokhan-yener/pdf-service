<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Teminat",
 *   type="object"
 * )
 */
class ApplicationFormGuarantee
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, example="Vefat Teminatı")
     */
    private $title;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minimum=1, maxLength=64, example="1.000")
     */
    private $price;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=3, example="TL", enum={"TL", "$"})
     */
    private $currency;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     * @SWG\Property(type="boolean", description="If true, a solid underline is drawn, otherwise a dotted.")
     */
    private $isMainCategory;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ApplicationFormGuarantee
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return ApplicationFormGuarantee
     */
    public function setPrice(string $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return ApplicationFormGuarantee
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsMainCategory()
    {
        return $this->isMainCategory;
    }

    /**
     * @param bool $isMainCategory
     * @return ApplicationFormGuarantee
     */
    public function setIsMainCategory(bool $isMainCategory)
    {
        $this->isMainCategory = $isMainCategory;
        return $this;
    }
}
