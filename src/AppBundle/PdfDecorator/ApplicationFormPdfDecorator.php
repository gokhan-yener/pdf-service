<?php

namespace AppBundle\PdfDecorator;


use AppBundle\PdfModel\ApplicationFormPdf\ApplicationFormLifestyle;

class ApplicationFormPdfDecorator extends AbstractPdfDecorator
{
    /**
     * Prepares data for all pages
     */
    public function prepareData()
    {
        $layoutData = $this->prepareLayoutData();
        $guaranteesData = $this->prepareGuaranteesData();
        $paymentData = $this->preparePaymentData();
        $identificationData = $this->prepareIdentificationData();
        $lifestyleData = $this->prepareLifestyleData();

        $this
            ->addLayout($layoutData)
            ->addPage($guaranteesData['slug'], $guaranteesData['data'])
            ->addPage($paymentData['slug'], $paymentData['data'])
            ->addPage($identificationData['slug'], $identificationData['data'])
            ->addPage($lifestyleData['slug'], $lifestyleData['data']);

        $healthBasic = $this->getModel()->getHealthBasic();
        $healthExtended = $this->getModel()->getHealthExtended();

        if ($healthBasic) {
            $healthBasicData = $this->prepareHealthBasicData();
            $this->addPage($healthBasicData['slug'], $healthBasicData['data']);
        } elseif ($healthExtended) {
            $healthExtendedData = $this->prepareHealthExtendedData();
            $this->addPage($healthExtendedData['slug'], $healthExtendedData['data']);
        }

        $confirmationData = $this->prepareConfirmationData();
        $this->addPage($confirmationData['slug'], $confirmationData['data']);
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

        if ($this->getModel()->getConfirmation()->getInsurerInitialsImageData()) {

            $layout['initials'] = $this->getImageDataArea($this->getModel()->getConfirmation()->getInsurerInitialsImageData(), false);

        } else {

            if ($initials = $this->getModel()->getConfirmation()->getInsurerInitialsImageUrl()) {
                $layout['initials'] = $this->getImageArea($initials, false);
            } else {
                $layout['initials'] = $this->getImageArea(self::WHITE_FRAME);
            }
        }
        return $layout;
    }

    /**
     * Returns the rendered HTML for guarantees
     * @return string
     */
    private function renderGuaranteesHtml()
    {
        $guaranteesHtml = '';
        if ($guarantees = $this->getModel()->getGuarantees()) {

            $styleMainL = 'border-bottom: 1px solid #ddd;';
            $styleMainR = 'border-bottom: 1px solid #ddd; text-align:right;';

            $styleSubL = 'border-bottom: 1px dashed #ddd;';
            $styleSubR = 'border-bottom: 1px dashed #ddd; text-align:right;';

            $guaranteesData = [];
            foreach ($guarantees as $guarantee) {
                $styleL = $guarantee->getIsMainCategory() ? $styleMainL : $styleSubL;
                $styleR = $guarantee->getIsMainCategory() ? $styleMainR : $styleSubR;

                $guaranteesData[] = [
                    'left' => ['style' => $styleL, 'text' => $guarantee->getTitle()],
                    'right' => ['style' => $styleR, 'text' => $guarantee->getPrice() . ' ' . $guarantee->getCurrency()],
                ];
            }

            $guaranteesExplanation = $this->getModel()->getGuaranteesExplanation();

            $guaranteesHtml = $this->renderView('@App/html/ApplicationFormPdf/_guarantees.html.twig', [
                'guarantees' => $guaranteesData,
                'guarantees_explanation' => $guaranteesExplanation,
            ]);
        }

        return $guaranteesHtml;
    }

    /**
     * Returns the rendered HTML for endorseds
     * @return string
     */
    private function renderEndorsedsHtml()
    {
        $endorsedsHtml = '';
        if ($endorseds = $this->getModel()->getEndorseds()) {

            $endorsedsData = [];
            foreach ($endorseds as $endorsed) {
                $endorsedsData[] = [
                    'name' => $endorsed->getName() ?? '',
                    'personal_id_number' => $endorsed->getPersonalIdNumber() ?? '',
                    'percent' => $endorsed->getPercent() ? '%' . $endorsed->getPercent() : '',
                ];
            }

            $endorsedsHtml = $this->renderView('@App/html/ApplicationFormPdf/_endorseds.html.twig', ['endorseds' => $endorsedsData]);
        }

        return $endorsedsHtml;
    }

    /**
     * Returns the rendered HTML for additional guarantees
     * @param array $tableHeader
     * @param array $tableData
     * @return string
     */
    private function renderAdditionalGuaranteesHtml(array $tableHeader, array $tableData)
    {
        $guaranteesHtml = '';
        if (0 < count($tableHeader) && 0 < count($tableData)) {
            $template = (1 === count($tableData))
                ? '@App/html/ApplicationFormPdf/_additional_guarantees_single.html.twig'
                : '@App/html/ApplicationFormPdf/_additional_guarantees.html.twig';

            $guaranteesHtml = $this->renderView($template, [
                'header' => $tableHeader,
                'data' => $tableData,
            ]);
        }

        return $guaranteesHtml;
    }

    /**
     * Returns the rendered HTML for bank account infos
     * @return string
     */
    private function renderBankAccountInfosHtml()
    {
        $infosHtml = '';
        if ($infos = $this->getModel()->getBankAccountInfos()) {

            $infosData = [];
            foreach ($infos as $info) {
                $infosData[] = [
                    'title' => $info->getTitle() ?? '',
                    'value' => $info->getValue() ?? '',
                ];
            }

            $infosHtml = $this->renderView('@App/html/ApplicationFormPdf/_bank_account.html.twig', ['bankAccountInfos' => $infosData]);
        }

        return $infosHtml;
    }

    /**
     * Prepares data for guarantees page
     * @return array
     */
    private function prepareGuaranteesData()
    {
        $numGuarantees = \count($this->getModel()->getGuarantees());

        return [
            'slug' => (3 >= $numGuarantees) ? '01-basvuru-teminatlar-02-dar' : '01-basvuru-teminatlar-01-genis',
            'data' => [
                'applicationNumber' => $this->getModel()->getApplicationNumber(),
                'campaignCode' => $this->getModel()->getCampaignCode(),
                'guaranteesTable' => $this->renderGuaranteesHtml(),
                'startDate' => $this->getModel()->getStartDate(),
                'endDate' => $this->getModel()->getEndDate(),
                'durationYears' => $this->getModel()->getDurationYears() . ' Yıl',
                'yearlyPrice' => $this->getModel()->getYearlyPrice() . ' ' . $this->getModel()->getYearlyPriceCurrency(),
            ],
        ];
    }

    /**
     * Prepares data for payment page
     * @return array
     */
    private function preparePaymentData()
    {
        $return = [
            'slug' => '02-basvuru-odeme',
            'data' => [],
        ];

        $data = [];

        if ($bankAccountInfos = $this->getModel()->getBankAccountInfos()) {
            // if $bankAccountInfos are set, render them
            $data['bankAccountTable'] = $this->renderBankAccountInfosHtml();

        } elseif ($creditCards = $this->getModel()->getCreditCards()) {
            // otherwise: if $creditCard(s) are set, render them
            $i = 1;
            foreach ($this->getModel()->getCreditCards() as $creditCard) {
                $cc = sprintf('cc%d', $i);

                $data[$cc . 'Background'] = $this->getImageArea(self::CC_BACKGROUND_IMAGE);
                $data[$cc . 'Title'] = 'Kredi Kartı ' . $i;
                $data[$cc . 'BankName'] = $creditCard->getBankName();
                $data[$cc . 'Number1'] = substr($creditCard->getNumber(), 0, 4);
                $data[$cc . 'Number2'] = '****';
                $data[$cc . 'Number3'] = '****';
                $data[$cc . 'Number4'] = substr($creditCard->getNumber(), 12, 4);
                $data[$cc . 'ExpirationDate'] = $creditCard->getExpirationDate();
                $data[$cc . 'OwnerName'] = $creditCard->getOwnerName();
                $data[$cc . 'Type'] = $creditCard->getType();

                if ($creditCard->getIsPreferred()) {
                    $data[$cc . 'PreferredCheckbox'] = $this->getImageArea(self::CIRCLE_MEDIUM_FILLED);
                    $data[$cc . 'PreferredLabel'] = 'Öncelikle bu kartı kullan';
                }

                $i++;
            }
        }

        $data['paymentPeriod' . $this->getModel()->getPaymentPeriodMonths()] = $this->getImageArea(self::CIRCLE_MEDIUM_FILLED);
        $data['periodicalPrice'] = $this->getModel()->getPeriodicalPrice() . ' ' . $this->getModel()->getPeriodicalPriceCurrency();

        $data['firstPaymentDate'] = $this->getModel()->getFirstPaymentDate();
        $data['monthlyPaymentDay'] = sprintf('Primlerim her ayın <b>%d. günü</b> ödensin.', $this->getModel()->getMonthlyPaymentDay());

        $data['insurerName'] = $this->getModel()->getInsurerName();
        $data['insurerPersonalId'] = $this->getModel()->getInsurerPersonalId();
        $data['insuredName'] = $this->getModel()->getInsuredName();
        $data['insuredPersonalId'] = $this->getModel()->getInsuredPersonalId();

        $data['endorsedsTable'] = $this->renderEndorsedsHtml();

        if ($mediator = $this->getModel()->getMediator()) {
            $data['mediatorCompany'] = sprintf(
                '<b>%s:</b> %s',
                $mediator->getCompanyType(),
                $mediator->getCompanyName()
            );

            $data['mediatorPerson'] = sprintf(
                '<b>%s:</b> %s',
                $mediator->getPersonType(),
                $mediator->getPersonName()
            );
        }

        $return['data'] = $data;

        return $return;
    }

    /**
     * Prepares data for identification page
     * @return array
     */
    private function prepareIdentificationData()
    {
        $model = $this->getModel();

        $insuredPerson = $model->getInsuredPerson();
        if (!$insuredPerson) {
            return ['slug' => '03-basvuru-kimlik-01-kendi', 'data' => []];
        }

        $data['insuredPersonalIdNumber'] = $insuredPerson->getPersonalIdNumber();
        $data['insuredLastName'] = $insuredPerson->getLastName();
        $data['insuredFirstName'] = $insuredPerson->getFirstName();
        $data['insuredBirthDate'] = $insuredPerson->getBirthDate();
        $data['insuredSerialNumber'] = $insuredPerson->getSerialNumber();
        $data['insuredExpirationDate'] = $insuredPerson->getExpirationDate();
        $data['insuredGender'] = $insuredPerson->getGender();
        $data['insuredNationality'] = $insuredPerson->getNationality();
        $data['insuredMothersName'] = $insuredPerson->getMothersName();
        $data['insuredFathersName'] = $insuredPerson->getFathersName();
        $data['insuredUsaTinNumber'] = $insuredPerson->getUsaTinNumber();

        $insurerPerson = $model->getInsurerPerson();
        $insurerCompany = $model->getInsurerCompany();

        if (null === $insurerPerson && null !== $insurerCompany) {
            // insurer is a company
            $slug = '03-firma';

            $data['insurerRelationToInsured'] = $insurerCompany->getRelationToInsured();
            $data['insurerCompanyTitle'] = $insurerCompany->getTitle();
            $data['insurerCompanySector'] = $insurerCompany->getSector();
            $data['insurerCompanyRegistrationNumber'] = $insurerCompany->getRegistrationNumber();
            $data['insurerCompanyActivity'] = $insurerCompany->getActivity();
            $data['insurerCompanyTaxAdministration'] = $insurerCompany->getTaxAdministration();
            $data['insurerCompanyTaxId'] = $insurerCompany->getTaxId();
            $data['insurerCompanyPhoneNumber'] = $insurerCompany->getPhoneNumber();
            $data['insurerCompanyPhoneNumberMobile'] = $insurerCompany->getPhoneNumberMobile();
            $data['insurerCompanyEmailAddress'] = $insurerCompany->getEmailAddress();
            $data['insurerCompanyWebsite'] = $insurerCompany->getWebsite();
            $data['insurerCompanyAddress'] = $insurerCompany->getAddress();

            if ($employee = $insurerCompany->getEmployee()) {
                $data['insurerEmployeeFullName'] = $employee->getFirstName() . ' ' . $employee->getLastName();
                $data['insurerEmployeePersonalIdNumber'] = $employee->getPersonalIdNumber();
                $data['insurerEmployeeSerialNumber'] = $employee->getSerialNumber();
                $data['insurerEmployeeMothersName'] = $employee->getMothersName();
                $data['insurerEmployeeGender'] = $employee->getGender();
                $data['insurerEmployeeEducation'] = $employee->getEducation();
                $data['insurerEmployeeBirthDate'] = $employee->getBirthDate();
                $data['insurerEmployeeExpirationDate'] = $employee->getExpirationDate();
                $data['insurerEmployeeFathersName'] = $employee->getFathersName();
                $data['insurerEmployeeNationality'] = $employee->getNationality();
                $data['insurerEmployeeProfession'] = $employee->getProfession();
                $data['insurerEmployeeUsaTinNumber'] = $employee->getUsaTinNumber();
                $data['insurerEmployeePhoneNumber'] = $employee->getPhoneNumber();
                $data['insurerEmployeePhoneNumberMobile'] = $employee->getPhoneNumberMobile();
                $data['insurerEmployeeEmailAddress'] = $employee->getEmailAddress();
                $data['insurerEmployeeAddressHome'] = $employee->getAddressHome();
                $data['insurerEmployeeAddressWork'] = $employee->getAddressWork();
            }
        } else if (null !== $insurerPerson && null === $insurerCompany) {
            // insurer is another person
            $slug = '02-baskasi';

            $data['insurerRelationToInsured'] = $insurerPerson->getRelationToInsured();
            $data['insurerLastName'] = $insurerPerson->getLastName();
            $data['insurerFirstName'] = $insurerPerson->getFirstName();
            $data['insurerPersonalIdNumber'] = $insurerPerson->getPersonalIdNumber();
            $data['insurerSerialNumber'] = $insurerPerson->getSerialNumber();
            $data['insurerMothersName'] = $insurerPerson->getMothersName();
            $data['insurerGender'] = $insurerPerson->getGender();
            $data['insurerEducation'] = $insurerPerson->getEducation();
            $data['insurerBirthDate'] = $insurerPerson->getBirthDate();
            $data['insurerExpirationDate'] = $insurerPerson->getExpirationDate();
            $data['insurerFathersName'] = $insurerPerson->getFathersName();
            $data['insurerNationality'] = $insurerPerson->getNationality();
            $data['insurerProfession'] = $insurerPerson->getProfession();
            $data['insurerUsaTinNumber'] = $insurerPerson->getUsaTinNumber();
            $data['insurerPhoneNumber'] = $insurerPerson->getPhoneNumber();
            $data['insurerPhoneNumberMobile'] = $insurerPerson->getPhoneNumberMobile();
            $data['insurerEmailAddress'] = $insurerPerson->getEmailAddress();
            $data['insurerAddressHome'] = $insurerPerson->getAddressHome();
            $data['insurerAddressWork'] = $insurerPerson->getAddressWork();
            $data['insurerSelectedPostalAddress'] = $insurerPerson->getSelectedPostalAddress();
            $data['insurerSelectedNotificationForm'] = $insurerPerson->getSelectedNotificationForm();
        } else {
            // insurer is insured person himself
            $slug = '01-kendi';

            $data['insuredEducation'] = $insuredPerson->getEducation();
            $data['insuredProfession'] = $insuredPerson->getProfession();
            $data['insuredPhoneNumber'] = $insuredPerson->getPhoneNumber();
            $data['insuredPhoneNumberMobile'] = $insuredPerson->getPhoneNumberMobile();
            $data['insuredEmailAddress'] = $insuredPerson->getEmailAddress();
            $data['insuredAddressHome'] = $insuredPerson->getAddressHome();
            $data['insuredAddressWork'] = $insuredPerson->getAddressWork();
            $data['insuredSelectedPostalAddress'] = $insuredPerson->getSelectedPostalAddress();
            $data['insuredSelectedNotificationForm'] = $insuredPerson->getSelectedNotificationForm();
        }

        $return = [
            'slug' => '03-basvuru-kimlik-' . $slug,
            'data' => $data,
        ];

        return $return;
    }

    /**
     * Prepares data for lifestyle page
     * @return array
     */
    private function prepareLifestyleData()
    {
        $slug = '04-basvuru-yasam-tarzi-';
        $data = [];

        $lifestyle = $this->getModel()->getLifestyle();
        if (!$lifestyle) {
            return ['slug' => $slug . '02-beyansiz', 'data' => []];
        }

        $healthDeclaration = $lifestyle->getHealthDeclaration();

        if (null === $healthDeclaration || '' === trim($healthDeclaration)) {
            $slug .= '02-beyansiz';
        } else {
            $slug .= '01-beyanli';
            $data['healthDeclaration'] = $healthDeclaration;
        }


        $tplVars = [];
        $questionNum = 1;

        // smoking
        $tplVars['smoking']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
        if ($lifestyle->getIsSmoking()) {
            $tplVars['smoking']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_TRUE;
            $tplVars['smoking']['numSmokingPerDay'] = $lifestyle->getNumSmokingPerDay();
        } else {
            $tplVars['smoking']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_FALSE;
        }
        $questionNum++;

        // drinking
        $tplVars['drinking']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
        if ($lifestyle->getIsDrinking()) {
            $tplVars['drinking']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_TRUE;
            $tplVars['drinking']['drinkingPeriod'] = $lifestyle->getDrinkingPeriod();
        } else {
            $tplVars['drinking']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_FALSE;
        }
        $questionNum++;

        // sports
        $tplVars['sports']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
        if ($lifestyle->getIsDoingExtremeSports()) {
            $tplVars['sports']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_TRUE;
            $tplVars['sports']['sportsExplanation'] = $lifestyle->getExtremeSportsExplanation();
        } else {
            $tplVars['sports']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_FALSE;
        }
        $questionNum++;

        // army
        if ($lifestyle->getIsArmyAsked()) {
            $tplVars['army']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
            if (!$lifestyle->getWasAtArmy()) {
                $tplVars['army']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_FALSE;

                // TODO
                $armyStatus = $lifestyle->getArmyStatus();
                switch ($armyStatus) {
                    case ApplicationFormLifestyle::ARMY_STATUS_EXEMPTED:
                        $imgStatus = self::LINE_RADIO_BOXES_1;
                        break;
                    case ApplicationFormLifestyle::ARMY_STATUS_DELAYED:
                        $imgStatus = self::LINE_RADIO_BOXES_2;
                        break;
                    case ApplicationFormLifestyle::ARMY_STATUS_NOTYET:
                        $imgStatus = self::LINE_RADIO_BOXES_3;
                        break;
                    default:
                        $imgStatus = self::LINE_RADIO_BOXES;
                }

                $tplVars['army']['imgStatus'] = $this->getServerName() . $this->getImagesWebDir() . '/' . $imgStatus;
                $tplVars['army']['armyExplanation'] = $lifestyle->getArmyExplanation();
            } else {
                $tplVars['army']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_TRUE;
            }
            $questionNum++;
        }

        // body
        $tplVars['body']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
        $tplVars['body']['imgBody'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::BODY_ICON;
        $tplVars['body']['height'] = $lifestyle->getHeight();
        $tplVars['body']['weight'] = $lifestyle->getWeight();
        $questionNum++;

        // education
        $tplVars['education']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
        $tplVars['education']['answer'] = $lifestyle->getEducation();
        $questionNum++;

        // profession
        $tplVars['profession']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
        $tplVars['profession']['answer'] = $lifestyle->getProfession();
        $questionNum++;

        // travelling
        if ($lifestyle->getIsTravellingAsked()) {
            $tplVars['travelling']['imgNumber'] = $this->getServerName() . $this->getImagesWebDir() . '/' . sprintf(self::CIRCLE_SMALL_NUMBERS_COUNTED, $questionNum);
            if ($lifestyle->getIsTravelling()) {
                $tplVars['travelling']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_TRUE;
                $tplVars['travelling']['travellingExplanation'] = $lifestyle->getTravellingCountries();
            } else {
                $tplVars['travelling']['imgYesNo'] = $this->getServerName() . $this->getImagesWebDir() . '/' . self::CHECKBOX_BIG_FALSE;
            }
        }

        $data['htmlLifestyle'] = $this->renderView('@App/html/ApplicationFormPdf/lifestyle.html.twig', ['vars' => $tplVars]);

        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }

    /**
     * Prepares data for basic health page
     * @return array
     */
    private function prepareHealthBasicData()
    {
        $slug = '05-basvuru-saglik-bilgileri-';
        $data = [];

        $health = $this->getModel()->getHealthBasic();
        if (!$health) {
            return ['slug' => '05-basvuru-saglik-bilgileri-01-sade', 'data' => []];
        }

        if ($health->hasAdditionalGuarantees()) {
            $slug .= '02-hesaplamali';

            $tableHeader = [
                'nameTitle' => $health->getAdditionalGuaranteesNameTitle(),
                'beforeTitle' => $health->getAdditionalGuaranteesBeforeTitle(),
                'percentTitle' => $health->getAdditionalGuaranteesPercentTitle(),
                'afterTitle' => $health->getAdditionalGuaranteesAfterTitle(),
            ];

            $tableData = [];
            $rows = $health->getAdditionalGuaranteesTableRows();
            foreach ($rows as $row) {
                $tableData[] = [
                    'name' => $row->getName(),
                    'feeBefore' => $row->getFeeBefore(),
                    'feePercent' => $row->getFeePercent(),
                    'feeAfter' => $row->getFeeAfter(),
                ];
            }

            $data['additionalGuaranteesHtml'] = $this->renderAdditionalGuaranteesHtml($tableHeader, $tableData);
            $data['additionalGuaranteesExplanation'] = $health->getAdditionalGuaranteesExplanation();
        } else {
            $slug .= '01-sade';
        }

        if ($health->getHasVisitedPhysician()) {
            $data['hasVisitedPhysician'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasVisitedPhysicianExplanation'] = $health->getHasVisitedPhysicianExplanation();
        } else {
            $data['hasVisitedPhysician'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasIllnessExplanation()) {
            $data['hasIllnessExplanationImg'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasIllnessExplanation'] = $health->getHasIllnessExplanation();
        }


        if ($health->getHasTakenMedications()) {
            $data['hasTakenMedications'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasTakenMedicationsExplanation'] = $health->getHasTakenMedicationsExplanation();
        } else {
            $data['hasTakenMedications'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasIllnessHeart()) {
            $data['hasIllnessHeart'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessNervousSystem()) {
            $data['hasIllnessNervousSystem'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessColitis()) {
            $data['hasIllnessColitis'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessDiabetes()) {
            $data['hasIllnessDiabetes'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessParalysis()) {
            $data['hasIllnessParalysis'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessOthers()) {
            $data['hasIllnessOthers'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessKidneys()) {
            $data['hasIllnessKidneys'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessCancer()) {
            $data['hasIllnessCancer'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessHypertension()) {
            $data['hasIllnessHypertension'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasIllnessHepatitis()) {
            $data['hasIllnessHepatitis'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        }

        if ($health->getHasReceivedDisabilitiesPayment()) {
            $data['hasReceivedDisabilitiesPayment'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasReceivedDisabilitiesPaymentExplanation'] = $health->getHasReceivedDisabilitiesPaymentExplanation();
        } else {
            $data['hasReceivedDisabilitiesPayment'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasDeclinedApplicationForInsurance()) {
            $data['hasDeclinedApplicationForInsurance'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasDeclinedApplicationForInsuranceExplanation'] = $health->getHasDeclinedApplicationForInsuranceExplanation();
        } else {
            $data['hasDeclinedApplicationForInsurance'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }


        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }

    /**
     * Prepares data for extended health page
     * @return array
     */
    private function prepareHealthExtendedData()
    {
        $slug = '06-basvuru-saglik-bilgileri-';
        $data = [];

        $health = $this->getModel()->getHealthExtended();
        if (!$health) {
            return ['slug' => $slug . '-01-sade', 'data' => []];
        }

        if ($health->hasAdditionalGuarantees()) {
            $slug .= '02-hesaplamali';

            $tableHeader = [
                'nameTitle' => $health->getAdditionalGuaranteesNameTitle(),
                'beforeTitle' => $health->getAdditionalGuaranteesBeforeTitle(),
                'percentTitle' => $health->getAdditionalGuaranteesPercentTitle(),
                'afterTitle' => $health->getAdditionalGuaranteesAfterTitle(),
            ];

            $tableData = [];
            $rows = $health->getAdditionalGuaranteesTableRows();
            foreach ($rows as $row) {
                $tableData[] = [
                    'name' => $row->getName(),
                    'feeBefore' => $row->getFeeBefore(),
                    'feePercent' => $row->getFeePercent(),
                    'feeAfter' => $row->getFeeAfter(),
                ];
            }

            $data['additionalGuaranteesHtml'] = $this->renderAdditionalGuaranteesHtml($tableHeader, $tableData);
            $data['additionalGuaranteesExplanation'] = $health->getAdditionalGuaranteesExplanation();
        } else {
            $slug .= '01-sade';
        }

        // page 1
        if ($health->getHasChronicIllness()) {
            $data['hasChronicIllness'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasChronicIllnessExplanation'] = $health->getHasChronicIllnessExplanation();
        } else {
            $data['hasChronicIllness'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasAnyIllnessBelow()) {
            $data['hasAnyIllnessBelow'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);

            if ($health->getHasIllnessCardiovascular()) {
                $data['hasIllnessCardiovascular'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessCardiovascularExplanation()) {
                $data['hasIllnessCardiovascularExplanation'] = $health->getHasIllnessCardiovascularExplanation();
            }

            if ($health->getHasIllnessRespiratory()) {
                $data['hasIllnessRespiratory'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessRespiratoryExplanation()) {
                $data['hasIllnessRespiratoryExplanation'] = $health->getHasIllnessRespiratoryExplanation();
            }

            if ($health->getHasIllnessGenitourinary()) {
                $data['hasIllnessGenitourinary'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessGenitourinaryExplanation()) {
                $data['hasIllnessGenitourinaryExplanation'] = $health->getHasIllnessGenitourinaryExplanation();
            }

            if ($health->getHasIllnessKidneyStone()) {
                $data['hasIllnessKidneyStone'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessGenitourinaryOther()) {
                $data['hasIllnessGenitourinaryOther'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessDigestiveExplanation()) {
                $data['hasIllnessDigestiveExplanation'] = $health->getHasIllnessDigestiveExplanation();
            }

            if ($health->getHasIllnessDigestive()) {
                $data['hasIllnessDigestive'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }
            if ($health->getHasIllnessDigestiveOther()) {
                $data['hasIllnessDigestiveOther'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasGallbladderRemoved()) {
                $data['hasGallbladderRemoved'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessNervous()) {
                $data['hasIllnessNervous'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessNervousExplanation()) {
                $data['hasIllnessNervousExplanation'] = $health->getHasIllnessNervousExplanation();
            }

            if ($health->getHasIllnessGland()) {
                $data['hasIllnessGland'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessGlandExplanation()) {
                $data['hasIllnessGlandExplanation'] = $health->getHasIllnessGlandExplanation();
            }

            if ($health->getHasIllnessUnexplainable()) {
                $data['hasIllnessUnexplainable'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
            }

            if ($health->getHasIllnessUnexplainableExplanation()) {
                $data['hasIllnessUnexplainableExplanation'] = $health->getHasIllnessUnexplainableExplanation();
            }

            if ($health->getHasIllnessOther()) {
                $data['hasIllnessOther'] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
                $data['hasIllnessOtherExplanation'] = $health->getHasIllnessOtherExplanation();
            }
        } else {
            $data['hasAnyIllnessBelow'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getWasAtHospital()) {
            $data['wasAtHospital'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['wasAtHospitalExplanation'] = $health->getWasAtHospitalExplanation();
        } else {
            $data['wasAtHospital'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);

        }

        if ($health->getHasHivSuspicion()) {
            $data['hasHivSuspicion'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasHivSuspicionExplanation'] = $health->getHasHivSuspicionExplanation();
        } else {
            $data['hasHivSuspicion'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        // page 2
        if ($health->getHasVisitedPhysician()) {
            $data['hasVisitedPhysician'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['circleHasVisitedPhysicianRoutinely'] = $this->getImageArea(self::CIRCLE_SMALL_SHAPED);
            $data['hasVisitedPhysicianRoutinelyLabel'] = 'Rutin Kontroller';
            $data['circleHasVisitedPhysicianOther'] = $this->getImageArea(self::CIRCLE_SMALL_SHAPED);
            $data['hasVisitedPhysicianOtherLabel'] = 'Diğer';
            $visitTypeSlug = $health->getVisitTypeSlug();
            $data['hasVisitedPhysician' . $visitTypeSlug] = $this->getImageArea(self::CIRCLE_SMALL_FILLED);
        } else {
            $data['hasVisitedPhysician'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasReceivedBloodTransfusion()) {
            $data['hasReceivedBloodTransfusion'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasReceivedBloodTransfusionExplanation'] = $health->getHasReceivedBloodTransfusionExplanation();
        } else {
            $data['hasReceivedBloodTransfusion'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasReceivedDisabilityPayments()) {
            $data['hasReceivedDisabilityPayments'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasReceivedDisabilityPaymentsExplanation'] = $health->getHasReceivedDisabilityPaymentsExplanation();
        } else {
            $data['hasReceivedDisabilityPayments'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasParalysis()) {
            $data['hasParalysis'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasParalysisExplanation'] = $health->getHasParalysisExplanation();
        } else {
            $data['hasParalysis'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasTransplantation()) {
            $data['hasTransplantation'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasTransplantationExplanation'] = $health->getHasTransplantationExplanation();
        } else {
            $data['hasTransplantation'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasSimilarProblems()) {
            $data['hasSimilarProblems'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasSimilarProblemsExplanation'] = $health->getHasSimilarProblemsExplanation();
        } else {
            $data['hasSimilarProblems'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasRejectedInsurance()) {
            $data['hasRejectedInsurance'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasRejectedInsuranceExplanation'] = $health->getHasRejectedInsuranceExplanation();
        } else {
            $data['hasRejectedInsurance'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        if ($health->getHasNotificationOfIllness()) {
            $data['hasNotificationOfIllness'] = $this->getImageArea(self::CHECKBOX_BIG_TRUE);
            $data['hasNotificationOfIllnessExplanation'] = $health->getHasNotificationOfIllnessExplanation();
        } else {
            $data['hasNotificationOfIllness'] = $this->getImageArea(self::CHECKBOX_BIG_FALSE);
        }

        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }

    /**
     * Prepares data for confirmation page
     * @return array
     */
    private function prepareConfirmationData()
    {
        $slug = '08-basvuru-onay';
        $data = [];

        $confirmation = $this->getModel()->getConfirmation();
        if (!$confirmation) {
            return ['slug' => $slug, 'data' => []];
        }


        $data['insurerName'] = $confirmation->getInsurerName();
        $data['insurerSigningDate'] = $confirmation->getInsurerSigningDate();


        if ($confirmation->getInsurerSignImageData()) {
            $data['insurerSign'] = $this->getImageDataArea($confirmation->getInsurerSignImageData(), false);
        } else {
            if ($confirmation->getInsurerSignImageUrl()) {
                $data['insurerSign'] = $this->getImageArea($confirmation->getInsurerSignImageUrl(), false);
            } else {
                $data['insurerSignFrame'] = $this->getImageArea(self::INSURER_WHITE_FRAME);
                $data['insurerSignFrame_up'] = $this->getImageArea(self::INSURER_WHITE_FRAME);
            }
        }


        if ($confirmation->getCompanyEmployeeName()) {

            if ($confirmation->getCompanySignImageData()) {
                $data['companySign'] = $this->getImageDataArea($confirmation->getCompanySignImageData(), false);
            } else {
                $data['companySign'] = $this->getImageArea($confirmation->getCompanySignImageUrl(), false);

            }

            $data['companyArea'] = $this->getImageArea(self::APP_FORM_COMPANY_AREA);
            $data['companyName'] = $confirmation->getCompanyName();

            $data['companyPersonName'] = $confirmation->getCompanyEmployeeName();
            $data['companySigningDate'] = $confirmation->getCompanySigningDate();
        }


        return [
            'slug' => $slug,
            'data' => $data,
        ];
    }
}
