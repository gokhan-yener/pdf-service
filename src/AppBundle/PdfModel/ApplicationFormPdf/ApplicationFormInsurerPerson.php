<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Sigorta Ettiren (Şahıs)",
 *   type="object"
 * )
 */
class ApplicationFormInsurerPerson
{
    use Person;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Sigortalı ile yakınlık derecesi", example="Amcası")
     */
    private $relationToInsured;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Yazışma Adresi", example="Ev", enum={"Ev", "İş"})
     */
    private $selectedPostalAddress;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Bilgilendirme Aracı", example="E-Posta", enum={"E-Posta", "SMS"})
     */
    private $selectedNotificationForm;

    /**
     * @return string
     */
    public function getRelationToInsured()
    {
        return $this->relationToInsured;
    }

    /**
     * @param string $relationToInsured
     * @return ApplicationFormInsurerPerson
     */
    public function setRelationToInsured(string $relationToInsured)
    {
        $this->relationToInsured = $relationToInsured;
        return $this;
    }

    /**
     * @return string
     */
    public function getSelectedPostalAddress()
    {
        return $this->selectedPostalAddress;
    }

    /**
     * @param string $selectedPostalAddress
     * @return ApplicationFormInsurerPerson
     */
    public function setSelectedPostalAddress(string $selectedPostalAddress)
    {
        $this->selectedPostalAddress = $selectedPostalAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getSelectedNotificationForm()
    {
        return $this->selectedNotificationForm;
    }

    /**
     * @param string $selectedNotificationForm
     * @return Person
     */
    public function setSelectedNotificationForm(string $selectedNotificationForm)
    {
        $this->selectedNotificationForm = $selectedNotificationForm;
        return $this;
    }
}
