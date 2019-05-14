<?php

namespace AppBundle\PdfDecorator;


class RequirementsConfirmationPdfDecorator extends AbstractPdfDecorator
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

        return $layout;
    }

    /**
     * Prepares data for page
     * @return array
     */
    private function preparePageData()
    {
        $slug = '01-ihtiyac-teyit';
        $data = [];

        $model = $this->getModel();

        if ($model->getIsEndorsedHimself()) {
            $data['isEndorsedHimself'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsEndorsedSpouse()) {
            $data['isEndorsedSpouse'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsEndorsedChildren()) {
            $data['isEndorsedChildren'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsEndorsedOther()) {
            $data['isEndorsedOther'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($model->getIsAimSecurityForFamily()) {
            $data['isAimSecurityForFamily'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsAimSecurityForIllness()) {
            $data['isAimSecurityForIllness'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsAimChargeback()) {
            $data['isAimChargeback'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsAimSaving()) {
            $data['isAimSaving'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsAimEducationFunding()) {
            $data['isAimEducationFunding'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($model->getIsFeeLessThan2()) {
            $data['isFeeLessThan2'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsFee2To5()) {
            $data['isFee2To5'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsFee5To10()) {
            $data['isFee5To10'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsFee10To20()) {
            $data['isFee10To20'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsFeeMoreThan20()) {
            $data['isFeeMoreThan20'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($model->getIsTotalFeeLessThan2()) {
            $data['isTotalFeeLessThan2'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsTotalFee2To5()) {
            $data['isTotalFee2To5'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsTotalFee5To10()) {
            $data['isTotalFee5To10'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsTotalFee10To20()) {
            $data['isTotalFee10To20'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }
        if ($model->getIsTotalFeeMoreThan20()) {
            $data['isTotalFeeMoreThan20'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        $data['insurerNameAndSigningDate'] = $this->renderView('@App/html/RequirementsConfirmationPdf/_insurer_name_and_signing_date.html.twig', [
            'insurer_name' => $model->getInsurerName(),
            'signing_date' => $model->getInsurerSigningDate(),
        ]);

        if($model->getInsurerSignImageUrl()){
            $data['insurerSign'] = $this->getImageArea($model->getInsurerSignImageUrl(), false);
        }else{
            $data['insurerSignFrame'] = $this->getImageArea(self::INSURER_WHITE_FRAME_1);
        }


        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }
}
