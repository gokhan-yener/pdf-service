<?php

namespace AppBundle\PdfDecorator;


class InformationFormPdfDecorator extends AbstractPdfDecorator
{
    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getModel()->getBackUrl();
    }

    /**
     * Prepares data for all pages
     */
    public function prepareData()
    {
        $layoutData = $this->prepareLayoutData();
        $pageData = $this->preparePageData();

        $this
            ->addLayout($layoutData)
            ->addPage($pageData['slug'], $pageData['data'])
        ;
    }

    /**
     * Prepares layout data for all pages
     * @return array
     */
    private function prepareLayoutData()
    {
        $layout = [];

        if ($backUrl = $this->getModel()->getBackUrl()) {
            $layout['indexLink'] = $this->getImageArea(self::CC_BACK_IMAGE, true, $backUrl);
        }

        if ($initials = $this->getModel()->getInsurerInitialsImageUrl()) {
            $layout['initials'] = $this->getImageArea($initials, false);
        }else{
            $layout['initials'] = $this->getImageArea(self::WHITE_FRAME);
        }

        return $layout;
    }

    /**
     * Prepares data for page
     * @return array
     */
    private function preparePageData()
    {
        $slug = '04-bilgilendirme-formu';
        $data = [];

        $model = $this->getModel();

        $data['mediatorName'] = $model->getMediatorName();
        $data['mediatorAddress'] = $model->getMediatorAddress();
        $data['mediatorPhoneFax'] = $model->getMediatorPhoneFax();

        $data['companyName'] = $model->getCompanyName();
        $data['insurerName'] = $model->getInsurerName();
        $data['insurerSigningDate'] = $model->getInsurerSigningDate();
        $data['companyEmployeeName'] = $model->getCompanyEmployeeName();
        $data['companySigningDate'] = $model->getCompanySigningDate();
        $data['thresholdValue'] = $model->getThresholdValue();
        $data['thresholdValueDown'] = $model->getThresholdValueDown();


        if ($initials = $this->getModel()->getInsurerInitialsImageUrl()) {
            $data['initials'] = $this->getImageArea($initials, false);
        }else{
            $data['initials'] = $this->getImageArea(self::WHITE_FRAME);
        }

        if($model->getInsurerSignImageUrl()){
            $data['insurerSign'] = $this->getImageArea($model->getInsurerSignImageUrl(), false);
        }else{
            $data['insurerSignFrame'] = $this->getImageArea(self::INSURER_WHITE_FRAME);
        }

        if($model->getCompanySignImageUrl()){
            $data['companySign'] = $this->getImageArea($model->getCompanySignImageUrl(), false);
        }else{
            $data['companySignFrame'] = $this->getImageArea(self::INSURER_WHITE_FRAME);
        }



        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }
}
