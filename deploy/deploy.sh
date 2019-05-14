#!/bin/bash

set -e

cd ..
DIRECTORY="$( pwd )"
LOGDIRECTORY="$DIRECTORY/deploy/log"

source "$DIRECTORY/deploy/deploy_config.txt"

echo ""
echo "================================================================================"
echo "USAGE: ./deploy.sh [dry|backup]"
echo "    dry: dry run does not sync"
echo "    backup: takes a backup of all files"
echo "================================================================================"

# Make sure that we have the correct user
LOCALUSER="$(whoami)"
if [ $LOCALUSER != $DEPLOYMENT_USER ]; then
    echo ""
    echo "================================================================================"
    printf "ERROR: This script must be run by the user %s\n" $DEPLOYMENT_USER
    echo "================================================================================"
    exit
fi

echo ""
echo "================================================================================"
echo "Syncing files on ${#hosts_web_deploy[*]} hosts"
echo "================================================================================"
if [ "$1" == "dry" ]; then
    echo "This is a DRY-RUN, see log file!"
    echo "================================================================================"
elif [ "$1" == "backup" ]; then
    echo "This run includes a backup, see $DIRECTORY/bak!"
    echo "================================================================================"
fi

mkdir -p $LOGDIRECTORY >/dev/null

DEPLOYDATE=`date +%Y-%m-%d_%Hh%Mm`
LOGFILE="$LOGDIRECTORY/deploy-$DEPLOYDATE.log"

# Log
touch $LOGFILE >/dev/null
echo >>$LOGFILE
echo "================================================================================" >>$LOGFILE
echo 'Start: ' `date` >>$LOGFILE
echo "Syncing files on ${#hosts_web_deploy[*]} hosts" >>$LOGFILE
echo "================================================================================" >>$LOGFILE

echo "================================================================================"
echo 'Start: ' `date`
echo "Syncing files on ${#hosts_web_deploy[*]} hosts"
echo "================================================================================"

CONFIGDIR_FRE="$DIRECTORY/app/config"
CACHEDIR_FRE="$DIRECTORY/app/cache"
LOGSDIR_FRE="$DIRECTORY/app/logs"

CONFIGDIR_API="$DIRECTORY/apps/api/app/config"
CACHEDIR_API="$DIRECTORY/apps/api/app/cache"
LOGSDIR_API="$DIRECTORY/apps/api/app/logs"

BLOGDIR="$DIRECTORY/apps/blog"

for host_deploy in ${hosts_web_deploy[*]}
do
    echo ""
    echo "--------------------------------------------------------------------------------"
    printf "Syncing host %s\n" $host_deploy
    echo "--------------------------------------------------------------------------------"
    echo "--------------------------------------------------------------------------------" >>$LOGFILE
    printf "Syncing host %s\n" $host_deploy >>$LOGFILE
    echo "--------------------------------------------------------------------------------" >>$LOGFILE
    sleep 2

    # NOTE: Temporarily excluding /apps/api, but after finishing implementation of API, replace the line
    #       --exclude "$DIRECTORY/apps/api"
    #       ... by these:
    #       --exclude "$CONFIGDIR_API/parameters.yml" \
    #       --exclude "$CACHEDIR_API" \
    #       --exclude "$LOGSDIR_API" \
    if [ "$1" == "dry" ]; then
        rsync --dry-run -zavrR --delete --links --rsh="ssh -l root" $DIRECTORY root@$host_deploy:/ \
          --exclude "$CONFIGDIR_FRE/parameters.yml" \
          --exclude "$CACHEDIR_FRE" \
          --exclude "$LOGSDIR_FRE" \
          --exclude "$DIRECTORY/log" \
          --exclude "$DIRECTORY/web/download" \
          --exclude ".git" \
          --exclude ".idea" \
          --exclude ".DS_Store" \
          >>$LOGFILE;
    else
        if [ "$1" == "backup" ]; then
            # make backup
            ssh root@$host_deploy "cd $DIRECTORY/..; mkdir bak >/dev/null; tar -czf bak/$CURRENTDIR-bak-$DEPLOYDATE.tar.gz $CURRENTDIR; exit;";
        fi

        rsync -zavrR --delete --links --rsh="ssh -l root" $DIRECTORY root@$host_deploy:/ \
          --exclude "$CONFIGDIR_FRE/parameters.yml" \
          --exclude "$CACHEDIR_FRE" \
          --exclude "$LOGSDIR_FRE" \
          --exclude "$DIRECTORY/log" \
          --exclude "$DIRECTORY/web/download" \
          --exclude ".git" \
          --exclude ".idea" \
          --exclude ".DS_Store" \
          >>$LOGFILE;

        echo 'applying deployment'
        echo "">>$LOGFILE
        echo 'applying deployment'>>$LOGFILE

        # rename parameters.yml.dist to parameters.yml
        ssh root@$host_deploy "cd $CONFIGDIR_FRE; mv parameters.yml.dist parameters.yml; exit;";
        # ssh root@$host_deploy "cd $CONFIGDIR_API; mv parameters.yml.dist parameters.yml; exit;";

        # clear cache etc.
        ssh root@$host_deploy "cd $DIRECTORY; mkdir -p $CACHEDIR_FRE; mkdir -p $LOGSDIR_FRE; chmod -R 777 $CACHEDIR_FRE; chmod -R 777 $LOGSDIR_FRE; exit;";
        ssh root@$host_deploy "cd $DIRECTORY; ./deploy/deployment_apply.sh; chown -R $WWW_USER_WEB:$WWW_GROUP_WEB /var/www; exit;";
    fi

    echo "--------------------------------------------------------------------------------"
    printf "Finished syncing host %s\n" $host_deploy
    echo "--------------------------------------------------------------------------------"
    echo "--------------------------------------------------------------------------------" >>$LOGFILE
    printf "Finished syncing host %s\n" $host_deploy >>$LOGFILE
    echo "--------------------------------------------------------------------------------" >>$LOGFILE
    sleep 2
done

echo "================================================================================" >>$LOGFILE
echo 'End: ' `date` >>$LOGFILE
echo "Deployed hosts:" >>$LOGFILE
echo $DEPLOYMENT_HOST >>$LOGFILE
printf "%s\n" "${hosts_web_deploy[@]}" >>$LOGFILE
echo "================================================================================" >>$LOGFILE
echo ""
echo "================================================================================" >>$LOGFILE
echo "deployment[revision]=$CURRENTDIR $REVISION" >>$LOGFILE
echo "================================================================================" >>$LOGFILE

echo "================================================================================"
echo 'End: ' `date`
echo "Deployed hosts:"
echo $DEPLOYMENT_HOST
printf "%s\n" "${hosts_web_deploy[@]}"
echo "================================================================================"
echo ""
echo "================================================================================"
echo "deployment[revision]=$CURRENTDIR $REVISION"
echo "================================================================================"
