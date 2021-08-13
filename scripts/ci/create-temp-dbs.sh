#!/usr/bin/env bash
# create-temp-dbs.sh <number of temp databases>
# -- creates databases on mariadb server for use with testing, and generates corresponding env file

# We expose these credentials in an environment variable, in our jenkins pipeline.
# They're stored as a managed user/pass in jenkins. See the Jenkinsfile for more info.
db_user=$TESTDB_CRED_USR
db_pass=$TESTDB_CRED_PSW
db_port=23300

db_hosts[0]="dlsgmaria1.xvolve.com"
db_hosts[1]="dlsgmaria2.xvolve.com"
db_hosts[2]="dlsgmaria3.xvolve.com"

create_db() {
  # Each call to create_db, pick a random host
  random_host=$[$RANDOM % ${#db_hosts[@]}]
  db_hostname=${db_hosts[$random_host]}

  envname="test-${1}"
  fullenv=$(echo "test-${1}-${BUILD_TAG}" | perl -pe 's/(-|%[[:xdigit:]]{2}|%)/_/g')
  sql_cmd "CREATE DATABASE ${fullenv};"
  sql_cmd "CREATE USER 'u${fullenv}'@'%' IDENTIFIED BY 'jenkinstest123';"
  sql_cmd 'FLUSH PRIVILEGES;'
  sql_cmd "GRANT ALL PRIVILEGES ON ${fullenv}.* TO 'u${fullenv}'@'%';"
  emit_behat_env "${envname}" "${fullenv}" > .env.$envname
}

sql_cmd() {
  echo $* | mysql -u${db_user} -p${db_pass} -P ${db_port} -h ${db_hostname} mysql
}

# $1 - shortenv
# $2 - fullenv
emit_behat_env() {
  echo "APP_NAME=Bachelor"
  echo "APP_ENV=${1}"
  echo "APP_KEY=base64:OabrQbl7ND2ibqyvNTnQFYUPXCWXuJzXh3onR+QidTI="
  echo "APP_DEBUG=true"
  echo "APP_URL=http://localhost"
  echo ""
  echo "DB_CONNECTION=mysql"
  echo "DB_HOST=${db_hostname}"
  echo "DB_PORT=${db_port}"
  echo "DB_DATABASE=${2}"
  echo "DB_USERNAME=u${2}"
  echo "DB_PASSWORD=jenkinstest123"
  echo "DB_ENGINE=INNODB"
  echo "KICKBOX_API_KEY=live_80573f489fae58d782cf0bdfa730a4404e977fcd19405f2f76fb96d37f71fc76"
  egrep -v "^DB_|^APP_" .env.behat.example
}

for i in $(seq 1 $1);do
  create_db $i && echo "[.env.${envname}] Created db '${fullenv}'  { "DB_HOST": ${db_hostname}, "DB_USERNAME": 'u${fullenv}' }"
done

sql_cmd "FLUSH PRIVILEGES;"
