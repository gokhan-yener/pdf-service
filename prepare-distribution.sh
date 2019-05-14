echo "Removing temporary files"
rm -R log/*
rm -R web/download/*
rm -R var/cache/*
rm -R var/logs/*
rm -R var/sessions/*
rm -R var/tmp/*
rm -R app/cache/*
rm -R app/logs/*
rm -R app/sessions/*
rm -R app/tmp/*

echo "Removing hidden folders"
rm -R .git
rm -R .idea

echo "Preparing parameters.yml"
rm app/config/parameters.yml
cp app/config/parameters.yml.dist app/config/parameters.yml

echo "Setting file permissions"
chmod -R 777 log/
chmod -R 777 web/download
chmod -R 777 var/*
chmod -R 777 app/cache
chmod -R 777 app/logs
chmod -R 777 app/sessions
chmod -R 777 app/tmp
