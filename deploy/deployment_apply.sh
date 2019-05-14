#!/bin/bash
DIRECTORY="$( pwd )";

service nginx stop;
$DIRECTORY/deploy/clearcache.sh;
$DIRECTORY/deploy/restart_servers.sh;
