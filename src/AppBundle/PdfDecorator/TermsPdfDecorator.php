<?php

namespace AppBundle\PdfDecorator;


class TermsPdfDecorator extends AbstractPdfDecorator
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
        $specialTermsData = $this->prepareSpecialTermsData();
        $generalTermsData = $this->prepareGeneralTermsData();

        $this
            ->addLayout($layoutData)
            ->addPage($specialTermsData['slug'], $specialTermsData['data'])
            ->addPage($generalTermsData['slug'], $generalTermsData['data'])
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
    private function prepareSpecialTermsData()
    {
        $slug = '01-ozel-sartlar';
        $data = [];

        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }

    /**
     * Prepares data for page
     * @return array
     */
    private function prepareGeneralTermsData()
    {
        $slug = '02-genel-sartlar';
        $data = [];

        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }
}
