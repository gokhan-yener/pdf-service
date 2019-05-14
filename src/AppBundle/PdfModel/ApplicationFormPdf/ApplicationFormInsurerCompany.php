<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Sigorta Ettiren (Tüzel)",
 *   type="object"
 * )
 */
class ApplicationFormInsurerCompany
{
    use Company;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Sigortalı ile yakınlık derecesi", example="İş veren")
     */
    private $relationToInsured;

    /**
     * @var ApplicationFormInsurerCompanyEmployee
     * @JMS\Type("AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsurerCompanyEmployee")
     * @SWG\Property(ref=@Model(type=AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormInsurerCompanyEmployee::class))
     */
    private $employee;

    /**
     * @return string
     */
    public function getRelationToInsured()
    {
        return $this->relationToInsured;
    }

    /**
     * @param string $relationToInsured
     * @return ApplicationFormInsurerCompany
     */
    public function setRelationToInsured(string $relationToInsured)
    {
        $this->relationToInsured = $relationToInsured;
        return $this;
    }

    /**
     * @return Person
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Person $employee
     * @return ApplicationFormInsurerCompany
     */
    public function setEmployee(Person $employee)
    {
        $this->employee = $employee;
        return $this;
    }
}
