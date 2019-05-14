#!/bin/bash
cd ..;
DIR="$( pwd )";
FONTSDIR="$DIR/src/AppBundle/Resources/fonts";
SCRIPTDIR="$DIR/vendor/tecnickcom/tcpdf/tools";

$SCRIPTDIR/tcpdf_addfont.php -b -t TrueTypeUnicode -f 32 -i $FONTSDIR/senticosansdt-regular.ttf,$FONTSDIR/senticosansdt-bold.ttf,$FONTSDIR/senticosansdt-extrabold.ttf,$FONTSDIR/creditcard.ttf;
