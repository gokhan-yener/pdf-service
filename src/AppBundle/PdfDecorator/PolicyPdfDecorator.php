<?php

namespace AppBundle\PdfDecorator;


class PolicyPdfDecorator extends AbstractPdfDecorator
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
        $slug = '06-police';
        $data = [];

        $model = $this->getModel();

        $data['details'] = $this->renderDetailsHtml();
        $data['guarantees'] = $this->renderGuaranteesHtml();
        $data['paybackYears'] = $this->renderPaybackYearsHtml();

        if ($fees = $this->getModel()->getRedemptionFees()) {
            if (17 < \count($fees)) {
                $slug = '06-police-uzun';
            }
            $data['redemptionFees'] = $this->renderRedemptionFeesHtml($fees);
        }

        $data['insurerName'] = $model->getInsurerName();
        $data['insurerBirthDate'] = $model->getInsurerBirthDate();
        $data['insurerGender'] = $this->getImageArea('K' === $model->getInsurerGender() ? self::GENDER_FEMALE_ICON : self::GENDER_MALE_ICON);
        $data['insurerBirthPlace'] = $model->getInsurerBirthPlace();
        $data['insurerAddress'] = $model->getInsurerAddress();


        $data['insuredName'] = $model->getInsuredName();
        $data['insuredBirthDate'] = $model->getInsuredBirthDate();
        $data['insuredGender'] = $this->getImageArea('K' === $model->getInsuredGender() ? self::GENDER_FEMALE_ICON : self::GENDER_MALE_ICON);
        $data['insuredBirthPlace'] = $model->getInsuredBirthPlace();

        $data['endorseds'] = $this->renderEndorsedsHtml();

        $data['companyName'] = $model->getCompanyName();

        $data['mediatorDetails'] = $this->renderMediatorDetailsHtml();

        $data['signingDate'] = $model->getSigningDate();


        if($model->getAegonSignImageUrl()){
            $data['aegonSignFrame'] = $this->getImageArea(self::FRAME_FLAT_SIGN);
            $data['aegonSign'] = $this->getImageArea($model->getAegonSignImageUrl(), false);
        }



        if ($model->getIsSigned()) {

            $data['companySignFrame'] = $this->getImageArea(self::FRAME_FLAT_SIGN);
            $data['companySign'] = $this->getImageArea($model->getCompanySignImageUrl(), false);

        }

        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }

    /**
     * Returns the rendered HTML for details
     * @return string
     */
    private function renderDetailsHtml()
    {
        $detailsHtml = '';

        if ($details = $this->getModel()->getDetails()) {
            $detailsData = [];
            foreach ($details as $detail) {
                $detailsData[] = [
                    'label' => $detail->getLabel(),
                    'detail' => $detail->getDetail(),
                ];
            }

            $detailsFootnote = $this->getModel()->getDetailsFootnote();

            $detailsHtml = $this->renderView('@App/html/PolicyPdf/_details.html.twig', [
                'details' => $detailsData,
                'footnote' => $detailsFootnote,
            ]);
        }

        return $detailsHtml;
    }

    /**
     * Returns the rendered HTML for guarantees
     * @return string
     */
    private function renderGuaranteesHtml()
    {
        $html = '';

        if ($guarantees = $this->getModel()->getGuarantees()) {
            $data = [];
            foreach ($guarantees as $guarantee) {
                $data[] = [
                    'title' => $guarantee->getTitle(),
                    'price' => $guarantee->getPrice(),
                    'endorsed' => $guarantee->getEndorsed(),
                ];
            }

            $footnote = $this->getModel()->getGuaranteesFootnote();

            $html = $this->renderView('@App/html/PolicyPdf/_guarantees.html.twig', [
                'guarantees' => $data,
                'footnote' => $footnote,
            ]);
        }

        return $html;
    }

    /**
     * Returns the rendered HTML for endorseds
     * @return string
     */
    private function renderEndorsedsHtml()
    {
        $html = '';

        if ($endorseds = $this->getModel()->getEndorseds()) {
            $data = [];
            foreach ($endorseds as $endorsed) {
                $data[] = [
                    'name' => $endorsed->getName(),
                    'percent' => $endorsed->getPercent(),
                ];
            }

            $html = $this->renderView('@App/html/PolicyPdf/_endorseds.html.twig', [
                'endorseds' => $data,
            ]);
        }

        return $html;
    }

    /**
     * Returns the rendered HTML for mediator details
     * @return string
     */
    private function renderMediatorDetailsHtml()
    {
        $detailsHtml = '';

        if ($details = $this->getModel()->getMediatorDetails()) {
            $detailsData = [];
            foreach ($details as $detail) {
                $detailsData[] = [
                    'label' => $detail->getLabel(),
                    'detail' => $detail->getDetail(),
                ];
            }

            $detailsHtml = $this->renderView('@App/html/PolicyPdf/_mediator_details.html.twig', [
                'details' => $detailsData,
            ]);
        }

        return $detailsHtml;
    }

    /**
     * Returns the rendered HTML for redemption fees
     * @param array $fees
     * @return string
     */
    private function renderRedemptionFeesHtml($fees)
    {
        $html = '';

        $data = [];
        foreach ($fees as $fee) {
            $data[] = [
                'insuranceMonth' => $fee->getInsuranceMonth(),
                'cumulativeYearlyFee' => $fee->getCumulativeYearlyFee(),
                'mathematicalCounterpart' => $fee->getMathematicalCounterpart(),
                'redemptionDeductionRate' => $fee->getRedemptionDeductionRate(),
                'redemptionDeductionPrice' => $fee->getRedemptionDeductionPrice(),
                'redemptionPrice' => $fee->getRedemptionPrice(),
            ];
        }

        $html = $this->renderView('@App/html/PolicyPdf/_redemption_fees.html.twig', [
            'fees' => $data,
        ]);

        return $html;
    }

    /**
     * Returns the rendered HTML for payback years
     * @return string
     */
    private function renderPaybackYearsHtml()
    {
        $html = '';

        if ($years = $this->getModel()->getPaybackYears()) {
            $data = [];
            foreach ($years as $year) {
                $data[] = [
                    'year' => $year->getYear(),
                ];
            }

            $footnote = $this->getModel()->getPaybackYearsFootnote();

            $html = $this->renderView('@App/html/PolicyPdf/_payback_years.html.twig', [
                'paybacks' => $data,
                'footnote' => $footnote,
            ]);
        }

        return $html;
    }
}
