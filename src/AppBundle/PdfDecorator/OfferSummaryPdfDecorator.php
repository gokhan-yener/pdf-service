<?php

namespace AppBundle\PdfDecorator;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class OfferSummaryPdfDecorator extends AbstractPdfDecorator
{
    const PDF_TYPE_SLUG = '02-teklif-ozet';

    /**
     * Prepares data for all pages
     */
    public function prepareData()
    {
        $layoutData = $this->prepareLayoutData();
        $pageData = $this->preparePageData();

        $this
            ->addLayout($layoutData)
            ->addPage($pageData['slug'], $pageData['data']);
    }

    /**
     * Returns page title
     * @return string
     */
    private function getPageTitle()
    {
        $title = '';

        if (isset($this->insuranceNames[$this->getModel()->getInsuranceSlug()])) {
            $title = $this->insuranceNames[$this->getModel()->getInsuranceSlug()];
        }

        if (isset($this->pdfTypeNames[$this->getModel()->getPdfTypeSlug()])) {
            $title .= ' ' . $this->pdfTypeNames[$this->getModel()->getPdfTypeSlug()];
        }

        return $title;
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

        $layout['pageTitle'] = $this->getPageTitle();

        return $layout;
    }

    /**
     * Prepares data for page
     * @return array
     */


    private function preparePageData()
    {
        $slug = self::PDF_TYPE_SLUG;
        $data = [];

        $file_headers = @get_headers($this->getModel()->getOfferSummaryPdfUrl());

        if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {

            throw new NotFoundHttpException(sprintf("can not be found url %s , please check the parameter of offer_summary_pdf_url ", $this->getModel()->getOfferSummaryPdfUrl()));

        }

        if ($offerSummaryPdfUrl = $this->getModel()->getOfferSummaryPdfUrl()) {
            $data = [
                'originalPdfFile' => $offerSummaryPdfUrl,
                'margin' => [
                    'top' => 100,
                    'right' => 55,
                    'bottom' => 55,
                    'left' => 100,
                ],
            ];
        }

        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }
}
