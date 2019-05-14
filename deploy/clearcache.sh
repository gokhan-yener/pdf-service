#!/bin/bash
cd ..
DIRECTORY="$( pwd )";
rm -R $DIRECTORY/var/cache/*;
rm -R /dev/shm/cache/aegon-pdf-service/cache/*;
