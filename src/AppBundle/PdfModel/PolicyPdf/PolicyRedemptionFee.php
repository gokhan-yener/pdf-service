<?php

namespace AppBundle\PdfModel\PolicyPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Poliçe: Matematik Karşılık ve İştira Bedeli (sadece 'Ferdi Kazalı Prim İadeli HS' ve 'Prim İadeli HS')",
 *   type="object"
 * )
 */
class PolicyRedemptionFee
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="Sigorta Ayı", example="13-24")
     */
    private $insuranceMonth;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="Kümülatif Yıllık Prim", example="960")
     */
    private $cumulativeYearlyFee;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="Matematik Karsılık", example="668")
     */
    private $mathematicalCounterpart;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="İştira Kesinti Oranı", example="%95")
     */
    private $redemptionDeductionRate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="İştira Kesinti Tutarı", example="634")
     */
    private $redemptionDeductionPrice;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=32, description="İştira Bedeli", example="33")
     */
    private $redemptionPrice;

    /**
     * @return string
     */
    public function getInsuranceMonth()
    {
        return $this->insuranceMonth;
    }

    /**
     * @param string $insuranceMonth
     * @return PolicyRedemptionFee
     */
    public function setInsuranceMonth(string $insuranceMonth)
    {
        $this->insuranceMonth = $insuranceMonth;
        return $this;
    }

    /**
     * @return string
     */
    public function getCumulativeYearlyFee()
    {
        return $this->cumulativeYearlyFee;
    }

    /**
     * @param string $cumulativeYearlyFee
     * @return PolicyRedemptionFee
     */
    public function setCumulativeYearlyFee(string $cumulativeYearlyFee)
    {
        $this->cumulativeYearlyFee = $cumulativeYearlyFee;
        return $this;
    }

    /**
     * @return string
     */
    public function getMathematicalCounterpart()
    {
        return $this->mathematicalCounterpart;
    }

    /**
     * @param string $mathematicalCounterpart
     * @return PolicyRedemptionFee
     */
    public function setMathematicalCounterpart(string $mathematicalCounterpart)
    {
        $this->mathematicalCounterpart = $mathematicalCounterpart;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedemptionDeductionRate()
    {
        return $this->redemptionDeductionRate;
    }

    /**
     * @param string $redemptionDeductionRate
     * @return PolicyRedemptionFee
     */
    public function setRedemptionDeductionRate(string $redemptionDeductionRate)
    {
        $this->redemptionDeductionRate = $redemptionDeductionRate;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedemptionDeductionPrice()
    {
        return $this->redemptionDeductionPrice;
    }

    /**
     * @param string $redemptionDeductionPrice
     * @return PolicyRedemptionFee
     */
    public function setRedemptionDeductionPrice(string $redemptionDeductionPrice)
    {
        $this->redemptionDeductionPrice = $redemptionDeductionPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedemptionPrice()
    {
        return $this->redemptionPrice;
    }

    /**
     * @param string $redemptionPrice
     * @return PolicyRedemptionFee
     */
    public function setRedemptionPrice(string $redemptionPrice)
    {
        $this->redemptionPrice = $redemptionPrice;
        return $this;
    }
}
