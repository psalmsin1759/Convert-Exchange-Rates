#!/bin/sh

# Start the Cloud SQL Proxy  - GCP
/cloud_sql_proxy -dir=/cloudsql -instances=logical-signer-434716-v3:northamerica-northeast1:dripylux=tcp:3306 &

sleep 10


php artisan config:cache


php artisan migrate --force



exec php artisan serve --host=0.0.0.0 --port=8080

