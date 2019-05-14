<?php

namespace AppBundle\PdfModel;


interface PdfModelInterface
{
    public function getPolId();

    public function getPolicyNumber();

    public function getInsuranceSlug();

    public function getPdfTypeSlug();

    public function getIsArchivalRequired();

    public function getBackUrl();
}
