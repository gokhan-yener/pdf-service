<?php

namespace AppBundle\Service;

use AppBundle\Entity\Pdf;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use setasign\Fpdi\TcpdfFpdi;

class PdfFileService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var FileService
     */
    protected $fileService;

    /**
     * @var string Absolute path to template directory
     */
    protected $templateDir;

    /**
     * @var string Absolute path to images directory
     */
    protected $imagesDir;

    /**
     * @var bool Whether in debugging mode or not (default false)
     */
    protected $isDebugging = false;

    /**
     * @var float Default line with for drawing borders, rectangles
     */
    protected $defaultLineWidth = 0.2835;

    /**
     * @var array Default color
     */
    protected $defaultColor = ['r' => 0, 'g' => 0, 'b' => 0];

    /**
     * @var int Default font size
     */
    protected $defaultFontSize = 11;

    /**
     * @var string Default font family
     */
    protected $defaultFontFamily = 'helvetica';

    /**
     * @var int Default font stretching (percent)
     */
    protected $defaultFontStretching = 100;

    /**
     * @var string Default font style (
     */
    protected $defaultFontStyle = '';

    /**
     * @var string Default text alignment
     */
    protected $defaultTextAlign = '';

    /**
     * @var array Default settings for PDF
     */
    protected $pdfDefaults = [
        'font' => [
            'family' => 'helvetica',
            'stretching' => 100,
            'style' => '',
            'size' => 11,
            'color' => ['r' => 0, 'g' => 0, 'b' => 0],
        ],
    ];

    /**
     * @var array PDF type slug abbreviations
     */
    protected $pdfTypeSlugAbbreviations = [];

    /**
     * Constructor
     * @param ContainerInterface $container
     * @param FileService $fileService
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function __construct(
        ContainerInterface $container,
        FileService $fileService
    )
    {
        $this->container = $container;
        $this->fileService = $fileService;

        $rootDir = $this->fileService->getProjectRootDir();

        try {
            $templateDir = $this->container->getParameter('project_pdf_template_dir');
        } catch (InvalidArgumentException $e) {
            $templateDir = '/src/AppBundle/Resources/views/pdf';
        }

        try {
            $imagesDir = $this->container->getParameter('project_pdf_images_dir');
        } catch (InvalidArgumentException $e) {
            $imagesDir = '/web/images/pdf';
        }

        try {
            $pdfTypeSlugAbbreviations = $this->container->getParameter('pdf_type_slugs_map_abbreviations');
        } catch (InvalidArgumentException $e) {
            $pdfTypeSlugAbbreviations = [
                '01-ihtiyac-teyit' => '01-ihtc',
                '02-teklif-ozet' => '02-tklf',
                '03-basvuru-formu' => '03-basv',
                '04-bilgilendirme-formu' => '04-bilg',
                '05-ozel-ve-genel-sartlar' => '05-sart',
                '06-police' => '06-polc',
                '07-police-okuma-kilavuzu' => '07-klvz',
            ];
        }
        $this->pdfTypeSlugAbbreviations = $pdfTypeSlugAbbreviations;

        $this->setTemplateDir(realpath($rootDir . $templateDir));
        $this->setImagesDir(realpath($rootDir . $imagesDir));
    }

    /**
     * Gets template directory
     * @return string
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }

    /**
     * Sets template directory
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
     * @param bool $isDebugging
     */
    public function setIsDebugging(bool $isDebugging)
    {
        $this->isDebugging = $isDebugging;
    }

    /**
     * @param float $defaultLineWidth
     */
    public function setDefaultLineWidth(float $defaultLineWidth)
    {
        $this->defaultLineWidth = $defaultLineWidth;
    }

    /**
     * @param array $defaultColor
     */
    public function setDefaultColor(array $defaultColor)
    {
        $this->defaultColor = $defaultColor;
    }

    /**
     * @param int $defaultFontSize
     */
    public function setDefaultFontSize(int $defaultFontSize)
    {
        $this->defaultFontSize = $defaultFontSize;
    }

    /**
     * @param string $defaultFontFamily
     */
    public function setDefaultFontFamily(string $defaultFontFamily)
    {
        $this->defaultFontFamily = $defaultFontFamily;
    }

    /**
     * @param int $defaultFontStretching
     */
    public function setDefaultFontStretching(int $defaultFontStretching)
    {
        $this->defaultFontStretching = $defaultFontStretching;
    }

    /**
     * @param string $defaultFontStyle
     */
    public function setDefaultFontStyle(string $defaultFontStyle)
    {
        $this->defaultFontStyle = $defaultFontStyle;
    }

    /**
     * @param string $defaultTextAlign
     */
    public function setDefaultTextAlign(string $defaultTextAlign)
    {
        $this->defaultTextAlign = $defaultTextAlign;
    }

    /**
     * Sets PDF wide defaults
     * @param array $defaultConfig
     */
    public function setPdfDefaults(array $defaultConfig)
    {
        $this->pdfDefaults['font']['family'] = $defaultConfig['font']['family'] ?? $this->defaultFontFamily;
        $this->pdfDefaults['font']['stretching'] = $defaultConfig['font']['stretching'] ?? $this->defaultFontStretching;
        $this->pdfDefaults['font']['style'] = $defaultConfig['font']['style'] ?? $this->defaultFontStyle;
        $this->pdfDefaults['font']['size'] = $defaultConfig['font']['size'] ?? $this->defaultFontSize;
        $this->pdfDefaults['font']['color'] = $defaultConfig['font']['color'] ?? $this->defaultColor;
    }

    /**
     * Sets PDF font
     * @param TcpdfFpdi $pdf
     * @param $fontConfig
     * @return TcpdfFpdi
     */
    public function setPdfFont(TcpdfFpdi $pdf, $fontConfig)
    {
        $font = array_merge($this->pdfDefaults['font'], $fontConfig);

        $pdf->SetFont(
            $font['family'],
            $font['style'],
            $font['size']
        );

        $pdf->SetTextColor(
            $font['color']['r'],
            $font['color']['g'],
            $font['color']['b']
        );

        $pdf->setFontStretching($font['stretching']);

        return $pdf;
    }

    /**
     * @return array
     */
    public function getPdfTypeSlugAbbreviations()
    {
        return $this->pdfTypeSlugAbbreviations;
    }

    /**
     * Loads JSON config files
     * @param string $caseSlug
     * @param string $typeSlug
     * @param array $usedTemplateSlugs
     * @throws \InvalidArgumentException
     * @return array
     */
    private function loadJsonConfigs($caseSlug, $typeSlug, array $usedTemplateSlugs)
    {
        $config = [];

        $caseDirectory = $this->getTemplateDir() . '/' . $caseSlug;
        $mainConfigFileName = $caseDirectory . '/' . $typeSlug . '.json';

        if (!file_exists($mainConfigFileName)) {
            throw new \InvalidArgumentException(sprintf('The file %s does not exist.', $mainConfigFileName));
        }

        $config = json_decode(file_get_contents($mainConfigFileName), true);

        if (!isset($config['pagesConfigs']) || 0 === \count($config['pagesConfigs'])) {
            throw new \InvalidArgumentException(sprintf('Missing key "pagesConfigs" for sub configuration files in %s.', $mainConfigFileName));
        }

        $config['templateDir'] = $caseDirectory . '/' . $typeSlug;

        // make sure that 'templates' key exists
        if (!isset($config['templates'])) {
            $config['templates'] = [];
        }

        if (isset($config['pagesConfigs'])) {
            foreach ($config['pagesConfigs'] as $key => $pageConfig) {

                if (isset($usedTemplateSlugs[$pageConfig])) {
                    $subConfigFileName = $config['templateDir'] . '/' . $pageConfig . '.json';
                    if (!file_exists($subConfigFileName)) {
                        throw new \InvalidArgumentException(sprintf('The file %s does not exist.', $subConfigFileName));
                    }

                    $subConfig = json_decode(file_get_contents($subConfigFileName), true);
                    $config['templates'][$key] = $subConfig;
                }
            }
        }

        return $config;
    }

    /**
     * Returns array of used template slugs from given data
     * @param array $data
     * @return array
     */
    private function getTemplateSlugsFromData(array $data)
    {
        $blacklist = [
            'layout' => 'layout',
        ];

        $slugs = [];

        $keys = array_keys($data);

        foreach ($keys as $slug) {
            if (!isset($blacklist[$slug])) {
                $slugs[$slug] = $slug;
            }
        }

        return $slugs;
    }

    /**
     * Intitiates a new FPDI object and sets it's defaults
     * @return TcpdfFpdi
     */
    private function initFpdi()
    {
        // initiate FPDI
        $pdf = new TcpdfFpdi('P', 'pt');

        // disable header/footer (also prevents black bottom line for header)
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set margins
        $pdf->SetMargins(0, 0, 0, true);
        $pdf->setHeaderMargin(0);
        $pdf->setFooterMargin(0);

        // set page break margin to 0
        $pdf->SetAutoPageBreak(true, 0);

        return $pdf;
    }

    /**
     * Generates PDF document from templates
     * @param string $caseSlug
     * @param string $typeSlug
     * @param array $data
     * @param bool $isDebugging
     * @param bool $isApplyingLayout
     * @return TcpdfFpdi
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function generatePdfDocumentFromTemplates($caseSlug, $typeSlug, array $data, $isDebugging = false, $isApplyingLayout = false)
    {
        $this->setIsDebugging($isDebugging);
        $templateSlugs = $this->getTemplateSlugsFromData($data);

        $config = $this->loadJsonConfigs($caseSlug, $typeSlug, $templateSlugs);

        $pdf = $this->initFpdi();

        // set pdf wide defaults
        if (isset($config['defaults']) && 0 < \count($config['defaults'])) {
            $this->setPdfDefaults($config['defaults']);
        }

        if ($isApplyingLayout) {
            return $this->applyLayoutToPdfFile($pdf, $config, $data);
        }

        return $this->addPdfPagesFromTemplates($pdf, $config, $data);
    }


    /**
     * Applies a layout from a PDF file to an existing PDF file
     *
     * * The layout PDF's name is given in $config['templates'][<config-key>]['layoutFile']
     *   @see e.g. Resources/views/pdf/5-5-odullu-birikim/02-teklif-ozet.json
     *
     * * The PDF to change is given in $data[<config-key>]['originalPdfFile']
     *   @see e.g. OfferSummaryPdfDecorator
     *
     * * A valid <config-key> is e.g. "02-teklif-ozet"
     *
     * @param TcpdfFpdi $pdf
     * @param array $config
     * @param array $data
     * @return TcpdfFpdi
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     * @throws \Symfony\Component\Filesystem\Exception\FileNotFoundException
     */
    private function applyLayoutToPdfFile(TcpdfFpdi $pdf, array $config, array $data)
    {
        if (!isset($config['templates'], $config['templateDir'])) {
            return $pdf;
        }

        reset($config['templates']);
        $templateConfig = current($config['templates']);
        $configKeys = array_keys($config['templates']);
        $templateKey = array_shift($configKeys);

        if (!isset($data[$templateKey]['originalPdfFile'], $templateConfig['layoutFile'])) {
            return $pdf;
        }

        // load layout file
        $pdf->setSourceFile($config['templateDir'] . '/' . $templateConfig['layoutFile']);
        $layoutPdf = $pdf->importPage(1);

        // get layout elements
        $layoutAreas = [];
        if (isset($config['layoutAreas']) && 0 < \count($config['layoutAreas'])) {
            $layoutAreas = $config['layoutAreas'];
        }

        // load original PDF file to which the layout will be applied
        // NOTE: using "copy" makes the use of remote files possible
        $tmpFileName = $this->fileService->tempnam($this->fileService->getTempDir(), $templateKey . '-');
        $this->fileService->copy($data[$templateKey]['originalPdfFile'], $tmpFileName, true);

        $margin = [
            'top' => $data[$templateKey]['margin']['top'] ?? 0,
            'right' => $data[$templateKey]['margin']['right'] ?? 0,
            'bottom' => $data[$templateKey]['margin']['bottom'] ?? 0,
            'left' => $data[$templateKey]['margin']['left'] ?? 0,
        ];

        $pageCount = $pdf->setSourceFile($tmpFileName);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            $templateSize = $pdf->getTemplateSize($templateId);

            $width = $templateSize['width'];
            $height = $templateSize['height'];

            $pdf->AddPage();

            $pdf->useTemplate($layoutPdf, [
                'x' => 0,
                'y' => 0,
                'width' => $width,
                'height' => $height,
                'adjustPageSize' => true,
            ]);

            // use the imported page as template and adjust the page size
            $pdf->useTemplate($templateId, [
                'x' => $margin['top'],
                'y' => $margin['left'],
                'width' => $width - $margin['left'] - $margin['right'],
                'height' => $height - $margin['top'] - $margin['bottom'],
                'adjustPageSize' => false,
            ]);

            foreach ($layoutAreas as $layoutArea) {
                if (isset($layoutArea['type'], $layoutArea['name'])) {
                    // eventually add paging
                    if ('paging' === $layoutArea['type']) {
                        $areaName = $layoutArea['name'];
                        $pagingData = [
                            $areaName => [
                                'currentPage' => $pageNo,
                                'totalPages' => $pageCount,
                            ],
                        ];
                        $pdf = $this->addPagingArea($pdf, $layoutArea, $pagingData);
                    } else if (isset($data['layout'])) {
                        $pdf = $this->addArea($pdf, $layoutArea, $data['layout']);
                    }
                }
            }
        }

        // finally delete tmp file
        $this->fileService->deleteFile($tmpFileName);

        return $pdf;
    }

    /**
     * @param TcpdfFpdi $pdf
     * @param array $config
     * @param array $data
     * @return TcpdfFpdi
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    private function addPdfPagesFromTemplates(TcpdfFpdi $pdf, array $config, array $data)
    {
        // get layout elements
        $layoutAreas = [];
        if (isset($config['layoutAreas']) && 0 < \count($config['layoutAreas'])) {
            $layoutAreas = $config['layoutAreas'];
        }

        // FIXME: temporary workaround for calculating total number of pages
        $numTotalPages = 0;
        foreach ($config['templates'] as $templateConfig) {
            $numTotalPages += \count($templateConfig['pages']);
        }

        $currentPageCounter = 0;
        foreach ($config['templates'] as $templateName => $templateConfig) {
            $currentPageCounter++;
            // get the page count
            $pageCount = $pdf->setSourceFile($config['templateDir'] . '/' . $templateConfig['templateFile']);

            // iterate through all pages
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);

                $pdf->AddPage();

                // use the imported page as template and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

                $configPage = $pageNo - 1;
                if (isset($templateConfig['pages'][$configPage]['areas'])) {

                    foreach ($layoutAreas as $layoutArea) {
                        if (isset($layoutArea['type'], $layoutArea['name'])) {
                            // eventually add paging
                            if ('paging' === $layoutArea['type']) {
                                $areaName = $layoutArea['name'];
                                $pagingData = [
                                    $areaName => [
                                        'currentPage' => $currentPageCounter + $pageNo - 1,
                                        'totalPages' => $numTotalPages,
                                    ],
                                ];
                                $pdf = $this->addPagingArea($pdf, $layoutArea, $pagingData);
                            } else if (isset($data['layout'])) {
                                $pdf = $this->addArea($pdf, $layoutArea, $data['layout']);
                            }
                        }
                    }

                    $numPageAreas = \count($templateConfig['pages'][$configPage]['areas']);
                    for ($j = 0; $j < $numPageAreas; $j++) {

                        // get current area from json and add it
                        $area = $templateConfig['pages'][$configPage]['areas'][$j];
                        $pdf = $this->addArea($pdf, $area, $data[$templateName]);
                    }
                }
            }
        }

        return $pdf;
    }

    /**
     * @param TcpdfFpdi $pdf
     * @param array $area
     * @param array $data
     * @return TcpdfFpdi
     */
    private function addArea(TcpdfFpdi $pdf, array $area, array $data)
    {
        if (!isset(
            $area['type'],
            $area['name'],
            $area['x'],
            $area['y'],
            $area['width'],
            $area['height']
        )) {
            throw new \InvalidArgumentException('A valid area definition in configuration JSON must contain at least "name", "x", "y", "width", "height" and "type"');
        }

        switch ($area['type']) {
            case 'text':
                // add text
                $pdf = $this->addTextArea($pdf, $area, $data);
                break;
            case 'image':
                // add image
                $pdf = $this->addImageArea($pdf, $area, $data);
                break;
            case 'html':
                // add html
                $pdf = $this->addHtmlArea($pdf, $area, $data);
                break;
            default:
                // do nothing
        }

        return $pdf;
    }

    /**
     * Adds a new text area to the given PDF document
     * @param $pdf
     * @param array $area
     * @param array $data
     * @return TcpdfFpdi
     */
    private function addTextArea(TcpdfFpdi $pdf, array $area, array $data)
    {
        // get area name
        $areaName = $area['name'];

        if (isset($data[$areaName])) {
            $x = $area['x'];
            $y = $area['y'];
            $w = $area['width'];
            $h = $area['height'];

            $borderWidth = 0;
            if ($this->isDebugging) {
                // Draw red rect at bounds
                $pdf->SetDrawColor(255, 0, 0);
                $pdf->SetLineWidth($this->defaultLineWidth);
                $borderWidth = 1;
            }

            $fontConfig = $area['font'] ?? [];

            $pdf = $this->setPdfFont($pdf, $fontConfig);

            $align = $area['align'] ?? $this->defaultTextAlign;

            $pdf->SetXY($x, $y, $rtloff = true);

            $pdf->Cell(
                $w,
                $h,
                $data[$areaName],
                $border = $borderWidth,
                $ln = 0,
                $align,
                $fill = false,
                $link = '',
                $stretch = 0,
                $ignore_min_height = false,
                $calign = 'T',
                $valign = 'T'
            );
        }

        return $pdf;
    }

    /**
     * Adds a new image area to the given PDF document
     * @param $pdf
     * @param array $area
     * @param array $data
     * @return TcpdfFpdi
     */
    private function addImageArea(TcpdfFpdi $pdf, array $area, array $data)
    {
        // get area name
        $areaName = $area['name'];

        if (isset($data[$areaName]['img'])) {
            $x    = $area['x'];
            $y    = $area['y'];
            $w    = $area['width'];
            $h    = $area['height'];

            // check required fields
            $border = 0;
            if ($this->isDebugging) {
                // draw red rect at bounds
                $pdf->SetDrawColor(255, 0, 0);
                $pdf->SetLineWidth($this->defaultLineWidth);
                $border = 1;
            }

            $fileName = $data[$areaName]['img'];
            $link = $data[$areaName]['url'] ?? '';

            try {
                $pdf->Image(
                    $fileName
                    , $x
                    , $y
                    , $w
                    , $h
                    , ''
                    , $link
                    , ''
                    , false
                    , 72
                    , ''
                    , false
                    , false
                    , $border
                    , 'CM'
                );
            } catch (\Exception $e) {
                // do nothing
            }
        }

        return $pdf;
    }

    /**
     * Adds a new HTML area to the given PDF document
     * @param $pdf
     * @param array $area
     * @param array $data
     * @return TcpdfFpdi
     */
    private function addHtmlArea(TcpdfFpdi $pdf, array $area, array $data)
    {
        // get area name
        $areaName = $area['name'];

        if (isset($data[$areaName])) {
            $x = $area['x'];
            $y = $area['y'];
            $w = $area['width'];
            $h = $area['height'];

            $borderWidth = 0;
            if ($this->isDebugging) {
                // Draw red rect at bounds
                $pdf->SetDrawColor(255, 0, 0);
                $pdf->SetLineWidth($this->defaultLineWidth);
                $borderWidth = 1;
            }

            $fontConfig = $area['font'] ?? [];

            $pdf = $this->setPdfFont($pdf, $fontConfig);

            $align = $area['align'] ?? $this->defaultTextAlign;

            $pdf->writeHTMLCell(
                $w,
                $h,
                $x,
                $y,
                $data[$areaName],
                $border = $borderWidth,
                $ln = 0,
                $fill = false,
                $reseth = true,
                $align,
                $autopadding = false
            );
        }

        return $pdf;
    }

    /**
     * Adds a new paging area to the given PDF document
     * @param TcpdfFpdi $pdf
     * @param array $area
     * @param array $data
     * @return TcpdfFpdi
     */
    private function addPagingArea(TcpdfFpdi $pdf, array $area, array $data)
    {
        $format = $area['format'] ?? '{{currentPage}}';
        $areaName = $area['name'] ?? 'paging';

        $currentPage = $data[$areaName]['currentPage'] ?? '';
        if ('' === $currentPage) {
            return $pdf;
        }

        $totalPages = $data[$areaName]['totalPages'] ?? '';
        if ('' === $totalPages) {
            $format = '{{currentPage}}';
        }

        $paging = str_replace(['{{currentPage}}', '{{totalPages}}'], [$currentPage, $totalPages], $format);

        $data[$areaName] = $paging;

        return $this->addTextArea($pdf, $area, $data);
    }

    /**
     * Generates a file name from given parameters
     * @param string $polId
     * @param string $insuranceSlug
     * @param string $pdfTypeSlugAbbreviation
     * @return string
     */
    public function generateFileName($polId, $insuranceSlug, $pdfTypeSlugAbbreviation)
    {
        return sprintf('aegon_%s_%s_%s.pdf', $polId, $insuranceSlug, $pdfTypeSlugAbbreviation);
    }

    /**
     * Generates a directory name from given parameters
     * @param mixed $personalIdNumber
     * @param bool $isAbsolute
     * @return string
     */
    public function generateDirName($personalIdNumber, $isAbsolute = false)
    {
        $dirName = '';

        if ($isAbsolute) {
            $dirName .= $this->fileService->getDownloadDir() . '/';
        }

        $dirName .= $this->fileService->getDeepFolderNameById((int) $personalIdNumber);

        return $dirName;
    }

    /**
     * @param Pdf $pdf
     * @param bool $isDebugging
     * @param bool $isApplyingLayout
     * @return Pdf
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function savePdfFile(Pdf $pdf, $isDebugging = false, $isApplyingLayout = false)
    {
        $polId = $pdf->getPolId();
        $personalIdNumber = $pdf->getPersonalIdNumber();
        $insuranceSlug = $pdf->getInsuranceSlug();
        $pdfTypeSlug = $pdf->getPdfTypeSlug();
        $pdfTypeSlugAbbreviation = $this->pdfTypeSlugAbbreviations[$pdfTypeSlug] ?? '';

        $pdfData = $pdf->decodeJson($pdf->getJsonProcessed());

        $pdfFile = $this->generatePdfDocumentFromTemplates(
            $insuranceSlug,
            $pdfTypeSlug,
            $pdfData,
            $isDebugging,
            $isApplyingLayout
        );

        $saveDirRel = $this->generateDirName($personalIdNumber, false);
        $saveDirAbs = $this->generateDirName($personalIdNumber, true);

        $fileName = $this->generateFileName($polId, $insuranceSlug, $pdfTypeSlugAbbreviation);

        $pdf->setDirName($saveDirRel);
        $pdf->setFileName($fileName);

        // make sure directory exists
        $this->fileService->createDir($saveDirAbs);

        $filePath = $saveDirAbs . '/' . $fileName;
        $pdfFile->Output($filePath, 'F');

        return $pdf;
    }

    public function deleteSignDirectory(){
        $this->fileService->deleteDirectory($this->fileService->getProjectSignDir()."/img");
    }
}
