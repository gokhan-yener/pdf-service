<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Kurum Yetkilisi",
 *   type="object"
 * )
 */
class ApplicationFormInsurerCompanyEmployee
{
    use Person;
}
