#!/bin/bash

set -e

echo ""
echo "================================================================================"
echo "USAGE: ./docker-release.sh <release-version>"
echo "================================================================================"

if [ "$1" == "" ]; then
    echo "ERROR: You must provide a release version (e.g. '1.3.10')!"
    echo "================================================================================"
    echo ""
    exit
fi

VERSION=$1
START_DATE="$( date )"

## backup original parameters.yml
cp app/config/parameters.yml app/config/parameters.yml.orig

## parameters.yml => test
echo ""
echo "--------------------------------------------------------------------------------"
echo "Preparing Test Version $VERSION"
echo "--------------------------------------------------------------------------------"
cp app/config/parameters.yml.test app/config/parameters.yml
docker build -t registry.aegon.com.tr/pdfservice_test:$VERSION -f Dockerfile .

## parameters.yml => prod
echo ""
echo "--------------------------------------------------------------------------------"
echo "Preparing Prod Version $VERSION"
echo "--------------------------------------------------------------------------------"
cp app/config/parameters.yml.prod app/config/parameters.yml
docker build -t registry.aegon.com.tr/pdfservice_prod:$VERSION -f Dockerfile .

## restore original parameters.yml
mv app/config/parameters.yml.orig app/config/parameters.yml

## login
echo ""
echo "--------------------------------------------------------------------------------"
echo "Registry Login"
echo "--------------------------------------------------------------------------------"
docker login registry.aegon.com.tr

## push test
echo ""
echo "--------------------------------------------------------------------------------"
echo "Pushing Test Version $VERSION"
echo "--------------------------------------------------------------------------------"
docker push registry.aegon.com.tr/pdfservice_test:$VERSION

## push prod
echo ""
echo "--------------------------------------------------------------------------------"
echo "Pushing Prod Version $VERSION"
echo "--------------------------------------------------------------------------------"
docker push registry.aegon.com.tr/pdfservice_prod:$VERSION

echo ""
echo "================================================================================"
echo "Version  : $VERSION successfully released"
echo "Started  : $START_DATE"
echo 'Finished :' `date`
echo "================================================================================"
