<?php

namespace TestingBundle\Controller;

use AppBundle\Service\AegonPdfService;
use AppBundle\PdfDecorator\AbstractPdfDecorator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use setasign\Fpdi\TcpdfFpdi;

/**
 * Testing controller.
 *
 * @Route("/testing", options={ "i18n": false })
 */
class TestingController extends Controller
{
    protected function loadLayout($pdf, $file)
    {
        $pdf->setSourceFile($file);
        return $pdf->importPage(1);
    }

    /**
     * @Route("/xobject", name="testing.xobject")
     * @throws \InvalidArgumentException
     */
    public function xobjectAction(Request $request)
    {
        $fileService = $this->get('AppBundle\Service\FileService');
        $downloadDir = $fileService->getDownloadDir();

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

        $layout = $this->loadLayout($pdf, $downloadDir . '/' . 'test-teklif-ozeti-layout.pdf');

        //http://pdf.aegon.devo/download/test-teklif-ozeti.pdf
        //$fs = new Filesystem();

        $tmpFileName = $fileService->tempnam($fileService->getTempDir(), 'teklif-ozeti-');
        $fileService->copy('http://pdf.aegon.devo/download/test-teklif-ozeti.pdf', $tmpFileName, true);

        $pageCount = $pdf->setSourceFile($tmpFileName);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            $templateSize = $pdf->getTemplateSize($templateId);

            $width = $templateSize['width'];
            $height = $templateSize['height'];

            $pdf->AddPage();

            $pdf->useTemplate($layout, [
                'x' => 0,
                'y' => 0,
                'width' => $width,
                'height' => $height,
                'adjustPageSize' => true,
            ]);

            // use the imported page as template and adjust the page size
            $pdf->useTemplate($templateId, [
                'x' => 100,
                'y' => 100,
                'width' => $width - 150,
                'height' => $height - 150,
                'adjustPageSize' => false,
            ]);
        }

        return new Response(
            $pdf->Output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Expires' => 0
            ]
        );
    }

    /**
     * @Route("/", name="testing.index")
     * @throws \InvalidArgumentException
     */
    public function indexAction(Request $request)
    {
        $data = [
            'test' => 'bar',
        ];

        return $this->render('@Testing/Default/index.html.twig', $data);
    }

    private function renderGuaranteeTable()
    {
        $styleMain1 = 'border-bottom: 1px solid #ddd;';
        $styleMain2 = 'border-bottom: 1px solid #ddd; text-align:right;';

        $styleSub1 = 'border-bottom: 1px dashed #ddd;';
        $styleSub2 = 'border-bottom: 1px dashed #ddd; text-align:right;';

        $guaranteeData = [
            [
                'left' => ['style' => $styleMain1, 'text' => 'Vefat Teminatı'],
                'right' => ['style' => $styleMain2, 'text' => '1.000.000 TL']
            ],
            [
                'left' => ['style' => $styleSub1, 'text' => 'İlk 5 Yılında'],
                'right' => ['style' => $styleSub2, 'text' => '1.000.000 TL']
            ],
            [
                'left' => ['style' => $styleSub1, 'text' => 'İkinci 5 Yılında'],
                'right' => ['style' => $styleSub2, 'text' => '1.000.000 TL']
            ],
            [
                'left' => ['style' => $styleMain1, 'text' => 'Süre Sonu Prim İadesi Teminatı'],
                'right' => ['style' => $styleMain2, 'text' => '1.000.000 TL']
            ],
            [
                'left' => ['style' => $styleSub1, 'text' => 'İlk 5 Yılında'],
                'right' => ['style' => $styleSub2, 'text' => '1.000.000 TL']
            ],
            [
                'left' => ['style' => $styleSub1, 'text' => 'İkinci 5 Yılında'],
                'right' => ['style' => $styleSub2, 'text' => '1.000.000 TL']
            ],
        ];

        return $this->renderView('@Testing/Default/_test_table.html.twig', ['guarantees' => $guaranteeData]);
    }

    private function getHealthDeclaration($isInsurerHimself = true)
    {
        if ($isInsurerHimself) {
            return
                'Hayat Sigortası için yaptığım başvuru tarihi itibarıyla; son beş yıl içerisinde herhangi bir ' .
                'tedavi görmediğimi veya tedavi olmam gerektiğinin bana söylenmediğini veya fiziksel bir ' .
                'sakatlığımın ya da hastalığımın olmadığını, tamamen sağlıklı olduğumu beyan ediyor ve ' .
                'onaylıyorum.'
            ;
        }

        return
            'Hayat sigortası için yaptığım başvuru tarihi itibarıyla; Sigortalı Adayı\'nın son beş yıl ' .
            'içerisinde herhangi bir tedavi görmediğini veya tedavi olması gerektiğinin kendisine ' .
            'söylenmediğini veya fiziksel bir sakatlığının ya da hastalığının olmadığını, tamamen ' .
            'sağlıklı olduğunu beyan ediyor ve onaylıyorum.'
        ;
    }

    /**
     * @Route("/generate-pdf", name="testing.generate-pdf")
     * @throws \InvalidArgumentException
     */
    public function generatePdfAction(Request $request)
    {
        $pdfService = $this->get('AppBundle\Service\AegonPdfService');

        $caseSlug = '5+5-odullu-birikim';
        $typeSlug = '03-basvuru-formu';

        $backUrl = $request->headers->get('referer');
        $guaranteesTable = $this->renderGuaranteeTable();

        $data = [
            'layout' => [
                // footer ------------------------------
                'initials' => $pdfService->getImageArea('http://pdf.aegon.devo/download/test/paraf.jpg', false),
                'indexLink' => $pdfService->getImageArea('index.png', true, $backUrl),
            ],
            //*/
            // page 1 ------------------------------
            '01-basvuru-teminatlar' => [
                'applicationNumber' => '1234567890',
                'campaignCode' => '1234567',
                'guaranteesTable' => $guaranteesTable,
                'startDate' => '01/01/2018',
                'endDate' => '01/01/2028',
                'durationYears' => '10 Yıl',
                'yearlyPrice' => '1.000 $',
            ],
            // page 2 ------------------------------
            '02-basvuru-odeme' => [
                // credit card
                'cc1Background' => $pdfService->getImageArea('cc_background.png'),
                'cc1Title' => 'Kredi Kartı 1',
                'cc1BankName' => 'Garanti Bankası',
                'cc1Number1' => '4321',
                'cc1Number2' => '****',
                'cc1Number3' => '****',
                'cc1Number4' => '6543',
                'cc1ExpirationDate' => '01/23',
                'cc1OwnerName' => 'Vecihi Hürküş',
                'cc1Type' => 'MASTER',
                'cc2Background' => $pdfService->getImageArea('cc_background.png'),
                'cc2Title' => 'Kredi Kartı 2',
                'cc2BankName' => 'İş Bankası',
                'cc2Number1' => '4321',
                'cc2Number2' => '****',
                'cc2Number3' => '****',
                'cc2Number4' => '6543',
                'cc2ExpirationDate' => '01/23',
                'cc2OwnerName' => 'İsmail Hamza',
                'cc2Type' => 'VISA',
                'cc2PreferredCheckbox' => $pdfService->getImageArea('circle_medium_filled.png'),
                'cc2PreferredLabel' => 'Öncelikle bu kartı kullan',

                // payment period
                'paymentPeriod3' => $pdfService->getImageArea('circle_medium_filled.png'),
                'periodicalPrice' => '1.350 TL',
                'firstPaymentDate' => '21 Ocak',
                'monthlyPaymentDay' => sprintf('Primlerim her ayın <b>%d. günü</b> ödensin.', 21),

                // insurer
                'insurerName' => 'Vecihi Hürküşoğlu',
                'insurerPersonalId' => '0216*****555',
                'insuredName' => 'İsmail Hamzaçınar',
                'insuredPersonalId' => '0216*****666',

                // endorsed
                'endorsee1Name' => 'Hatice Hamzaçınar',
                'endorsee1Phone' => '0216*****777',
                'endorsee1Percent' => '%40',
                'endorsee2Name' => 'Çağla Hürküşoğlu',
                'endorsee2Phone' => '0216*****888',
                'endorsee2Percent' => '%60',
                //'endorsee1Name' => 'Kanuni Mirasçılar',

                // mediator
                //'mediatorCompany' => sprintf('<b>%s:</b> %s', 'Acente', 'Özgerçek Sigorta'),
                //'mediatorPerson' => sprintf('<b>%s:</b> %s', 'Aracı', 'Emel Akın'),
                //'mediatorCompany' => sprintf('<b>%s:</b> %s', 'Şube', 'Samsun Şubesi'),
                //'mediatorPerson' => sprintf('<b>%s:</b> %s', 'Aracı', 'Emel Akdağ'),
                'mediatorCompany' => sprintf('<b>%s:</b> %s', 'Bölge', 'Karadeniz Bölgesi'),
                'mediatorPerson' => sprintf('<b>%s:</b> %s', 'Finansal Güvence Danışmanı', 'Emel Sayın'),
            ],
            // page 3 ------------------------------
            //'03-basvuru-kimlik-01-kendi' => [
            //    'insuredPersonalIdNumber' => '12345678910',
            //    'insuredLastName' => 'Hamzaçınar',
            //    'insuredFirstName' => 'İsmail',
            //    'insuredBirthDate' => '03.03.1980',
            //    'insuredSerialNumber' => 'A3568Z5460',
            //    'insuredExpirationDate' => '23.23.2023',
            //    'insuredGender' => 'E',
            //    'insuredNationality' => 'TC',
            //    'insuredMothersName' => 'Hamide',
            //    'insuredFathersName' => 'Gıyaseddin',
            //    'insuredUsaTinNumber' => '1234567890',
            //
            //    'insuredEducation' => 'Lise',
            //    'insuredProfession' => 'Muhasebeci',
            //    'insuredUsaTinNumber' => '1234567890',
            //    'insuredPhoneNumber' => '0 (216) 555 55 55',
            //    'insuredPhoneNumberMobile' => '0 (555) 555 55 55',
            //    'insuredEmailAddress' => 'ismail@example.com',
            //    'insuredAddressHome' => 'Yenişehir Mah. Atatürk Cad. Evim Sok. No. 15, Kadıköy-İstanbul',
            //    'insuredAddressWork' => 'Eskişehir Mah. İnönü Cad. İşyerim Sok. No. 25, Üsküdar-İstanbul',
            //    'insuredSelectedPostalAddress' => 'Ev',
            //    'insuredSelectedNotificationForm' => 'e-posta',
            //],
            //'03-basvuru-kimlik-02-baskasi' => [
            //    'insuredPersonalIdNumber' => '12345678910',
            //    'insuredLastName' => 'Hamzaçınar',
            //    'insuredFirstName' => 'İsmail',
            //    'insuredBirthDate' => '03.03.1980',
            //    'insuredSerialNumber' => 'A3568Z5460',
            //    'insuredExpirationDate' => '23.23.2023',
            //    'insuredGender' => 'E',
            //    'insuredNationality' => 'TC',
            //    'insuredMothersName' => 'Hamide',
            //    'insuredFathersName' => 'Gıyaseddin',
            //    'insuredUsaTinNumber' => '1234567890',
            //
            //    'insurerRelationToInsured' => 'Amcası',
            //    'insurerPersonalIdNumber' => '99345678910',
            //    'insurerLastName' => 'Hürküşoğlu',
            //    'insurerFirstName' => 'Vecihi',
            //    'insurerBirthDate' => '02.02.1980',
            //    'insurerSerialNumber' => 'A3568Z5461',
            //    'insurerExpirationDate' => '22.22.2022',
            //    'insurerGender' => 'E',
            //    'insurerNationality' => 'TC',
            //    'insurerMothersName' => 'Fadime',
            //    'insurerFathersName' => 'Şinasi',
            //
            //    'insurerEducation' => 'Yüksek Lisans',
            //    'insurerProfession' => 'Avukat',
            //    'insurerUsaTinNumber' => '2224567890',
            //    'insurerPhoneNumber' => '0 (216) 666 66 66',
            //    'insurerPhoneNumberMobile' => '0 (566) 666 66 66',
            //    'insurerEmailAddress' => 'vecihi@example.com',
            //    'insurerAddressHome' => 'Yenişehir Mah. Atatürk Cad. Evimiz Sok. No. 15, Kadıköy-İstanbul',
            //    'insurerAddressWork' => 'Eskişehir Mah. İnönü Cad. İşyerimiz Sok. No. 25, Üsküdar-İstanbul',
            //    'insurerSelectedPostalAddress' => 'İş',
            //    'insurerSelectedNotificationForm' => 'Telefon',
            //],
            '03-basvuru-kimlik-03-firma' => [
                'insuredPersonalIdNumber' => '12345678910',
                'insuredLastName' => 'Hamzaçınar',
                'insuredFirstName' => 'İsmail',
                'insuredBirthDate' => '03.03.1980',
                'insuredSerialNumber' => 'A3568Z5460',
                'insuredExpirationDate' => '23.23.2023',
                'insuredGender' => 'E',
                'insuredNationality' => 'TC',
                'insuredMothersName' => 'Hamide',
                'insuredFathersName' => 'Gıyaseddin',
                'insuredUsaTinNumber' => '1234567890',

                'insurerRelationToInsured' => 'İş Veren',
                'insurerCompanyTitle' => 'Ulusal Özvarlık A.Ş.',
                'insurerCompanySector' => 'E-Ticaret',
                'insurerCompanyRegistrationNumber' => '7777777777',
                'insurerCompanyActivity' => 'Ürün Alım-Satım',
                'insurerCompanyTaxAdministration' => 'Üsküdar',
                'insurerCompanyTaxId' => '8888888888',
                'insurerCompanyPhoneNumber' => '0 (216) 888 88 88',
                'insurerCompanyPhoneNumberMobile' => '0 (530) 888 88 88',
                'insurerCompanyEmailAddress' => 'info@ozvarlik.com.tr',
                'insurerCompanyWebsite' => 'www.ozvarlik.com.tr',
                'insurerCompanyAddress' => 'Eskişehir Mah. İnönü Cad. İşyerimiz Sok. No. 25, Üsküdar-İstanbul',

                'insurerEmployeeFullName' => 'Emel Sayın',
                'insurerEmployeePersonalIdNumber' => '55545678910',
                'insurerEmployeeSerialNumber' => 'A3568Z5555',
                'insurerEmployeeMothersName' => 'Ayşe',
                'insurerEmployeeGender' => 'K',
                'insurerEmployeeEducation' => 'Üniversite',
                'insurerEmployeeBirthDate' => '02.02.1981',
                'insurerEmployeeExpirationDate' => '22.22.2022',
                'insurerEmployeeFathersName' => 'Halil',
                'insurerEmployeeNationality' => 'TC',
                'insurerEmployeeProfession' => 'Sigorta Acente Müdürü',
                'insurerEmployeeUsaTinNumber' => '9999999999',
                'insurerEmployeePhoneNumber' => '0 (216) 666 66 66',
                'insurerEmployeePhoneNumberMobile' => '0 (530) 111 11 11',
                'insurerEmployeeEmailAddress' => 'emel.sayin@example.com',
                'insurerEmployeeAddressHome' => 'Yenişehir Mah. Atatürk Cad. Evimiz Sok. No. 15, Kadıköy-İstanbul',
                'insurerEmployeeAddressWork' => 'Eskişehir Mah. İnönü Cad. İşyerimiz Sok. No. 25, Üsküdar-İstanbul',
            ],
            // page 4 ------------------------------
            '04-basvuru-yasam-tarzi-01-beyanli' => [
                'healthDeclaration' => $pdfService->getHealthDeclaration(false),
                'isSmoking' => ['img' => $pdfService->getImagePath('checkbox_big_true.png')],
                'numSmokingPerDay' => 20,
                'isDrinking' => ['img' => $pdfService->getImagePath('checkbox_big_true.png')],
                'drinkingPeriodDaily' => ['img' => $pdfService->getImagePath('circle_medium_filled.png')],
                'drinkingPeriodWeekly' => ['img' => $pdfService->getImagePath('circle_medium_filled.png')],
                'drinkingPeriodMonthly' => ['img' => $pdfService->getImagePath('circle_medium_filled.png')],
                'isDoingExtremeSports' => ['img' => $pdfService->getImagePath('checkbox_big_true.png')],
                'extremeSportsExplanation' => 'Dağcılık, Judo ve Yamaç Paraşütçülüğü yapıyorum. Onun haricinde bir şey yok. Ancak ileriki zamanlarda paraşüt atlamayı da denemek istiyorum. Havacılık hobimdir.',
                'wasAtArmy' => ['img' => $pdfService->getImagePath('checkbox_big_false.png')],
                'armyExempted' => ['img' => $pdfService->getImagePath('circle_medium_filled.png')],
                'armyDelayed' => ['img' => $pdfService->getImagePath('circle_medium_filled.png')],
                'armyNotYetTheTime' => ['img' => $pdfService->getImagePath('circle_medium_filled.png')],
                'armyExplanation' => 'Askerlikten muaf tutuldum çünkü belirli yiyeceklere karşı alerjim var. Alerji yüzünden muaf olmama aslında çok şaşırmıştım ama böylesini daha uygun gördüler.',
                'height' => '1 m 83 cm',
                'weight' => '89 kg',
                'education' => 'Yüksek Lisans',
                'profession' => 'Bilgisayar Mühendisi',
                'isTravelling' => ['img' => $pdfService->getImagePath('checkbox_big_true.png')],
                'travellingCountries' => 'Hollanda, Almanya, Amerika, Karayip Adaları, Fransa, Belçika, İsviçre, ABD, Güney Kongo Cumhuriyeti',
            ],
            //'04-basvuru-yasam-tarzi-02-beyansiz' => [
            //    'isSmoking' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'numSmokingPerDay' => 20,
            //    'isDrinking' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    //'drinkingPeriodDaily' => ['img' => $pdfService->getImagesDir() . '/circle_medium_filled.png'],
            //    //'drinkingPeriodWeekly' => ['img' => $pdfService->getImagesDir() . '/circle_medium_filled.png'],
            //    'drinkingPeriodMonthly' => ['img' => $pdfService->getImagesDir() . '/circle_medium_filled.png'],
            //    'isDoingExtremeSports' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'extremeSportsExplanation' => 'Dağcılık, Judo ve Yamaç Paraşütçülüğü yapıyorum. Onun haricinde bir şey yok. Ancak ileriki zamanlarda paraşüt atlamayı da denemek istiyorum. Havacılık hobimdir.',
            //    'wasAtArmy' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_false.png'],
            //    'armyExempted' => ['img' => $pdfService->getImagesDir() . '/circle_medium_filled.png'],
            //    'armyDelayed' => ['img' => $pdfService->getImagesDir() . '/circle_medium_filled.png'],
            //    'armyNotYetTheTime' => ['img' => $pdfService->getImagesDir() . '/circle_medium_filled.png'],
            //    'armyExplanation' => 'Askerlikten muaf tutuldum çünkü belirli yiyeceklere karşı alerjim var. Alerji yüzünden muaf olmama aslında çok şaşırmıştım ama böylesini daha uygun gördüler.',
            //    'height' => '1 m 83 cm',
            //    'weight' => '89 kg',
            //    'education' => 'Yüksek Lisans',
            //    'profession' => 'Bilgisayar Mühendisi',
            //    'isTravelling' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'travellingCountries' => 'Hollanda, Almanya, Amerika, Karayip Adaları, Fransa, Belçika, İsviçre, ABD, Güney Kongo Cumhuriyeti',
            //],
            // page 5 ------------------------------
            //'05-basvuru-saglik-bilgileri-01-sade' => [
            //    'hasVisitedPhysician' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasTakenMedications' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasIllnessHeart' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessNervousSystem' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessColitis' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessDiabetes' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessParalysis' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessOthers' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessKidneys' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessCancer' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessHypertension' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasIllnessHepatitis' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasReceivedDisabilitiesPayment' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasDeclinedApplicationForInsurance' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //],
            '05-basvuru-saglik-bilgileri-02-hesaplamali' => [
                'hasVisitedPhysician' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasTakenMedications' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasIllnessHeart' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessNervousSystem' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessColitis' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessDiabetes' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessParalysis' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessOthers' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessKidneys' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessCancer' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessHypertension' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessHepatitis' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasReceivedDisabilitiesPayment' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasDeclinedApplicationForInsurance' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'additionalFeeBefore' => '1.000 TL',
                'additionalFeePercent' => '%10',
                'additionalFeeAfter' => '1.000 TL',
            ],
            // page 6 ------------------------------
            '06-basvuru-saglik-bilgileri' => [
                'hasChronicIllness' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],

                'hasAnyIllnessBelow' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasIllnessCardiovascular' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessRespiratory' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessGenitourinary' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessKidneyStone' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessGenitourinaryOther' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessDigestive' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasGallbladderRemoved' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessNervous' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessGland' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessUnexplainable' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessOther' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasIllnessOtherExplanation' => 'Zamanında böbrek taşım olmuştu, ancak bitkisel yöntemlerle döktüm ve bir daha oluşmadı. Son 5 senedir herhangi bir sıkıntım yok.',

                'wasAtHospital' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasHivSuspicion' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            ],
            // page 7 ------------------------------
            '07-basvuru-saglik-bilgileri-01-sade' => [
                'hasVisitedPhysician' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasVisitedPhysicianRoutinely' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasVisitedPhysicianOther' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
                'hasReceivedBloodTransfusion' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasReceivedDisabilityPayments' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasParalysis' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasTransplantation' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasSimilarProblems' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasSimilarProblemsExplanation' => 'Zamanında buna benzer problemlerim olmuştu ama şimdi bir şeyim kalmadı. Herhangi bir rahatsızlığım veya sıkıntım yok şu an.',
                'hasRejectedInsurance' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
                'hasNotificationOfIllness' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            ],
            //'07-basvuru-saglik-bilgileri-02-hesaplamali' => [
            //    'hasVisitedPhysician' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasVisitedPhysicianRoutinely' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasVisitedPhysicianOther' => ['img' => $pdfService->getImagesDir() . '/circle_small_filled.png'],
            //    'hasReceivedBloodTransfusion' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasReceivedDisabilityPayments' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasParalysis' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasTransplantation' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasSimilarProblems' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasSimilarProblemsExplanation' => 'Zamanında buna benzer problemlerim olmuştu ama şimdi bir şeyim kalmadı. Herhangi bir rahatsızlığım veya sıkıntım yok şu an.',
            //    'hasRejectedInsurance' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'hasNotificationOfIllness' => ['img' => $pdfService->getImagesDir() . '/checkbox_big_true.png'],
            //    'additionalFeeBefore' => '1.000',
            //    'additionalFeePercent' => '%25',
            //    'additionalFeeAfter' => '275',
            //],
            //*/
            // page 8 ------------------------------
            '08-basvuru-onay' => [
                'companyName' => 'Özgerçek Sigorta',
                'insurerName' => 'Vecihi Hürküşoğlu',
                'insurerSigningDate' => '02.02.2018',
                'companyPersonName' => 'Emel Akın',
                'companySigningDate' => '03.02.2018',
                'insurerSign' => ['img' => 'http://pdf.aegon.devo/download/test/paraf.jpg'],
                'companySign' => ['img' => 'http://pdf.aegon.devo/download/test/paraf.jpg'],
            ],
        ];


//echo "<pre>";
//echo "<hr>";
//print_r($data);
//exit;

        $pdf = $pdfService->generatePdfDocumentFromTemplates(
            $caseSlug,
            $typeSlug,
            $data,
            /*/
            true
            /*/
            false
            //*/
        );

        return new Response(
            $pdf->Output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Expires' => 0
            ]
        );
    }
}
