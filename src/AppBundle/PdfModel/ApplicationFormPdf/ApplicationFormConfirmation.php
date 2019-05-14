<?php

namespace AppBundle\PdfModel\ApplicationFormPdf;


use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * @SWG\Definition(
 *   description="Başvuru Formu: Onay",
 *   type="object"
 * )
 */
class ApplicationFormConfirmation
{
    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Ad Soyad (Sigorta Ettiren)", example="Jane Doe")
     */
    private $insurerName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Tarih (Sigorta Ettiren)", example="01/01/2018")
     */
    private $insurerSigningDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="İmza Resim URL (Sigorta Ettiren)", example="http://www.example.com/imza1.jpg")
     */
    private $insurerSignImageUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", description="İmza Resim base64 Data (Sigorta Ettiren)", example="data:image/gif;base64,XCY..")
     */
    private $insurerSignImageData;


    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="Paraf Resim URL (Sigorta Ettiren)", example="http://www.example.com/paraf1.jpg")
     */
    private $insurerInitialsImageUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="data", description="Paraf Resim Data (Sigorta Ettiren)")
     */
    private $insurerInitialsImageData;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=3, maxLength=255, description="Şirket Ünvanı", example="Örnek Şirketi Ltd.")
     */
    private $companyName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", minLength=2, maxLength=255, description="Ad Soyad (Şirket Yetkilisi)", example="Jane Doe")
     */
    private $companyEmployeeName;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", maxLength=128, description="Tarih (Şirket Yetkilisi)", example="01/01/2018")
     */
    private $companySigningDate;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", format="uri", minLength=1, maxLength=1024, description="İmza Resim URL (Şirket Yetkilisi)", example="http://www.example.com/imza2.jpg")
     */
    private $companySignImageUrl;

    /**
     * @var string
     * @JMS\Type("string")
     * @SWG\Property(type="string", description="İmza Resim Data (Şirket Yetkilisi)", example="data:image/gif;base64,XCY..")
     */
    private $companySignImageData;

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return ApplicationFormConfirmation
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerName()
    {
        return $this->insurerName;
    }

    /**
     * @param string $insurerName
     * @return ApplicationFormConfirmation
     */
    public function setInsurerName(string $insurerName)
    {
        $this->insurerName = $insurerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerSigningDate()
    {
        return $this->insurerSigningDate;
    }

    /**
     * @param string $insurerSigningDate
     * @return ApplicationFormConfirmation
     */
    public function setInsurerSigningDate(string $insurerSigningDate)
    {
        $this->insurerSigningDate = $insurerSigningDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerSignImageUrl()
    {
        return $this->insurerSignImageUrl;
    }

    /**
     * @param string $insurerSignImageUrl
     * @return ApplicationFormConfirmation
     */
    public function setInsurerSignImageUrl(string $insurerSignImageUrl)
    {
        $this->insurerSignImageUrl = $insurerSignImageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerSignImageData()
    {
        return $this->insurerSignImageData;
    }

    /**
     * @param string $insurerSignImageData
     * @return ApplicationFormConfirmation
     */
    public function setInsurerSignImageData(string $insurerSignImageData)
    {
        $this->insurerSignImageData = $insurerSignImageData;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerInitialsImageUrl()
    {
        return $this->insurerInitialsImageUrl;
    }

    /**
     * @param string $insurerInitialsImageUrl
     * @return ApplicationFormConfirmation
     */
    public function setInsurerInitialsImageUrl(string $insurerInitialsImageUrl)
    {
        $this->insurerInitialsImageUrl = $insurerInitialsImageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsurerInitialsImageData()
    {
        return $this->insurerInitialsImageData;
    }

    /**
     * @param string $insurerInitialsImageData
     * @return ApplicationFormConfirmation
     */
    public function setInsurerInitialsImageData(string $insurerInitialsImageData)
    {
        $this->insurerInitialsImageData = $insurerInitialsImageData;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyEmployeeName()
    {
        return $this->companyEmployeeName;
    }

    /**
     * @param string $companyEmployeeName
     * @return ApplicationFormConfirmation
     */
    public function setCompanyEmployeeName(string $companyEmployeeName)
    {
        $this->companyEmployeeName = $companyEmployeeName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanySigningDate()
    {
        return $this->companySigningDate;
    }

    /**
     * @param string $companySigningDate
     * @return ApplicationFormConfirmation
     */
    public function setCompanySigningDate(string $companySigningDate)
    {
        $this->companySigningDate = $companySigningDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanySignImageUrl()
    {
        return $this->companySignImageUrl;
    }

    /**
     * @param string $companySignImageUrl
     * @return ApplicationFormConfirmation
     */
    public function setCompanySignImageUrl(string $companySignImageUrl)
    {
        $this->companySignImageUrl = $companySignImageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanySignImageData()
    {
        return $this->companySignImageData;
    }

    /**
     * @param string $companySignImageData
     * @return ApplicationFormConfirmation
     */
    public function setCompanySignImageData(string $companySignImageData)
    {
        $this->companySignImageData = $companySignImageData;
        return $this;
    }
}
