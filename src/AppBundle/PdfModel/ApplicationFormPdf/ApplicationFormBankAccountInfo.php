<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Otomatik Ödeme - Banka Hesabı Bilgisi",
 *   type="object"
 * )
 */
class ApplicationFormBankAccountInfo
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Hesap Bilgisi Başlığı", example="'Banka İsmi:' veya 'Hesap No:' gibi")
     */
    private $title;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=1, maxLength=255, description="Hesap Bilgisi Değeri", example="'Örnek Bankası' veya 'TR1234567812345678' gibi")
     */
    private $value;


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ApplicationFormBankAccountInfo
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return ApplicationFormBankAccountInfo
     */
    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }
}
