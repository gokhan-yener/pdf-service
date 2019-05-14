<?php

namespace AppBundle\PdfDecorator;


use AppBundle\PdfModel\PdfModelInterface;
use AppBundle\Service\FileService;
use Twig_Environment;

abstract class AbstractPdfDecorator
{
    const CC_BACK_IMAGE = 'index.png';
    const CC_BACKGROUND_IMAGE = 'cc_background.png';
    const CIRCLE_MEDIUM_FILLED = 'circle_medium_filled.png';
    const CIRCLE_SMALL_FILLED = 'circle_small_filled.png';
    const CHECKBOX_BIG_TRUE = 'checkbox_big_true.png';
    const CHECKBOX_BIG_FALSE = 'checkbox_big_false.png';
    const GENDER_FEMALE_ICON = 'icon_gender_female.png';
    const GENDER_MALE_ICON = 'icon_gender_male.png';
    const FRAME_FLAT_SIGN = 'frame_flat_sign.png';
    const CIRCLE_BIG_SHAPED = 'circle_big_shaped.png';
    const LINE_RADIO_BOXES = 'line_radio_boxes.png';
    const LINE_RADIO_BOXES_1 = 'line_radio_boxes_1.png';
    const LINE_RADIO_BOXES_2 = 'line_radio_boxes_2.png';
    const LINE_RADIO_BOXES_3 = 'line_radio_boxes_3.png';
    const CIRCLE_SMALL_NUMBERS = 'circle_small_numbers.png';
    const CIRCLE_SMALL_NUMBERS_COUNTED = 'circle_small_numbers_%d.png';
    const CIRCLE_SMALL_SHAPED = 'circle_small_shaped.png';
    const BODY_ICON = 'icon_body.png';
    const APP_FORM_COMPANY_AREA = 'app_company_area.png';
    const WHITE_FRAME = 'white_bg.png';
    const INSURER_WHITE_FRAME = 'insurer_white_bg.png';
    const INSURER_WHITE_FRAME_1 = 'insurer_white_bg_1.png';

    /**
     * @var PdfModelInterface
     */
    protected $model;

    /**
     * @var FileService
     */
    protected $fileService;

    /**
     * @var Twig_Environment
     */
    protected $templating;

    /**
     * @var string Absolute path to template directory
     */
    protected $templateDir;

    /**
     * @var string Absolute path to images directory
     */
    protected $imagesDir;

    /**
     * @var string Web path to images directory
     */
    protected $imagesWebDir;

    /**
     * @var array
     */
    protected $insuranceNames = [];

    /**
     * @var array
     */
    protected $pdfTypeNames = [];

    /**
     * @var array
     */
    protected $data = [];

    public function __construct(
        PdfModelInterface $model,
        FileService $fileService,
        Twig_Environment $templating,
        $templateDir,
        $imagesDir,
        $imagesWebDir,
        $insuranceNames,
        $pdfTypeNames
    )
    {
        $this->setModel($model);
        $this->fileService = $fileService;
        $this->templating = $templating;

        $rootDir = $this->fileService->getProjectRootDir();

        $this->setTemplateDir(realpath($rootDir . $templateDir));
        $this->setImagesDir(realpath($rootDir . $imagesDir));
        $this->setImagesWebDir($imagesWebDir);

        $this->insuranceNames = $insuranceNames;
        $this->pdfTypeNames = $pdfTypeNames;
    }

    /**
     * @return PdfModelInterface
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param PdfModelInterface $model
     */
    public function setModel(PdfModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }

    /**
     * @param string $templateDir
     */
    public function setTemplateDir(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    /**
     * @return string
     */
    public function getImagesDir()
    {
        return $this->imagesDir;
    }

    /**
     * @param string $imagesDir
     */
    public function setImagesDir(string $imagesDir)
    {
        $this->imagesDir = $imagesDir;
    }

    /**
     * @return string
     */
    public function getImagesWebDir()
    {
        return $this->imagesWebDir;
    }

    /**
     * @param string $imagesDir
     */
    public function setImagesWebDir(string $imagesDir)
    {
        $this->imagesWebDir = $imagesDir;
    }

    /**
     * @return string
     */
    public function getServerName()
    {
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? 'http';
        $scheme .= '://';

        $server = 'localhost';
        if (isset($_SERVER['SERVER_NAME'])) {
            $server = $_SERVER['SERVER_NAME'];
        } elseif (isset($_SERVER['SERVER_ADDR'])) {
            $server = $_SERVER['SERVER_ADDR'];
        }

        // ensure correct server name
        if ('_' === $server || '' === $server) {
            $server = 'localhost';
        }

        $port = ':';
        $port .= $_SERVER['SERVER_PORT'] ?? '80';

        $result = $scheme . $server . $port;

        return $result;
    }

    /**
     * @return string
     */
    public function getPolId()
    {
        return $this->model->getPolId();
    }

    /**
     * @return string
     */
    public function getPolicyNumber()
    {
        return $this->model->getPolicyNumber();
    }

    /**
     * @return string
     */
    public function getInsuranceSlug()
    {
        return $this->model->getInsuranceSlug();
    }

    /**
     * @return string
     */
    public function getPdfTypeSlug()
    {
        return $this->model->getPdfTypeSlug();
    }

    /**
     * @return boolean
     */
    public function getIsArchivalRequired()
    {
        return $this->model->getIsArchivalRequired();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Returns decorated data ready for writing on PDF
     * @return array
     */
    public function getDecoratedData()
    {
        $this->prepareData();

        return $this->getData();
    }

    /**
     * Prepares data for all pages
     */
    abstract public function prepareData();

    /**
     * @param array $areas
     * @return $this
     */
    public function addLayout(array $areas)
    {
        // make sure that 'layout' key exists
        if (!isset($this->data['layout'])) {
            $this->data['layout'] = [];
        }

        foreach ($areas as $key => $area) {
            $this->data['layout'][$key] = $area;
        }

        return $this;
    }

    /**
     * @param string $pageSlug
     * @param array $areas
     * @return $this
     */
    public function addPage($pageSlug, array $areas)
    {
        // make sure that $pageSlug key exists
        if (!isset($this->data[$pageSlug])) {
            $this->data[$pageSlug] = [];
        }

        foreach ($areas as $key => $area) {
            $this->data[$pageSlug][$key] = $area;
        }

        return $this;
    }

    /**
     * Returns absolute path to given image file
     * @param string $fileName
     * @return string
     */
    public function getImagePath(string $fileName)
    {
        return $this->getImagesDir() . '/' . $fileName;
    }

    /**
     * @param string $file
     * @param bool $isLocal
     * @param null $link
     * @return array
     */
    public function getImageArea(string $file, $isLocal = true, $link = null)
    {
        $image = $isLocal ? $this->getImagePath($file) : $file;
        $imageArea = [
            'img' => $image
        ];

        if (null !== $link) {
            $imageArea['url'] = $link;
        }

        return $imageArea;
    }

    /**
     * @param string $imageData
     * @param null $link
     * @return array
     */
    public function getImageDataArea(string $imageData, $link = null)
    {
        $image = $this->fileService->getImageUrlFromBase64($imageData);
        $imageArea = [
            'img' => $image
        ];

        if (null !== $link) {
            $imageArea['url'] = $link;
        }

        return $imageArea;
    }

    /**
     * Returns a rendered view
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    public function renderView(string $view, array $data = [])
    {
        return $this->templating->render($view, $data);
    }
}
