<?php

namespace AppBundle\PdfDecorator;


class PolicyManualPdfDecorator extends AbstractPdfDecorator
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
        $slug = '07-police-okuma-kilavuzu';
        $data = [];

        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }
}
