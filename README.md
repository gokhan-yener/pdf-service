# PDF-Service

## Development Environment

### Initial Setup (For Development Environment)

```bash
# create parameters.yml
cp app/config/parameters.yml.dist app/config/parameters.yml

# install Vendor Libraries
composer install

# create DB tables
php bin/console doctrine:schema:update --force
```

## Production Environment

### Running in Production Environment

```bash
# start
./app-start.sh

# stop
./app-start.sh
```

### Running Moreum Archival Command

```bash
docker-compose exec php bin/console app:moreum:archival --env=prod
```

### Execute SQL Query from CLI

```bash
docker-compose exec php bin/console doctrine:query:sql 'SELECT * FROM aegon_pdf'
```

### Access API Documentation

```
http://localhost/doc
# or
http://<server-ip>/doc
```

### Running Pdf Regenerate Command

```bash
docker-compose exec php bin/console app:pdf-regenerate --env=prod
```
###  send data to Kibana with Elasticsearch Command

```bash
docker-compose exec php bin/console fos:elastica:populate --env=prod
```
