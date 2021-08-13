#!/usr/bin/env bash
# drop-temp-dbs.sh <number of temp databases>
# -- drops databases on mariadb server for use with testing, and removes env file previously generated for testing 

# We expose these credentials in an environment variable, in our jenkins pipeline.
# They're stored as a managed user/pass in jenkins. See the Jenkinsfile for more info.
db_user=$TESTDB_CRED_USR
db_pass=$TESTDB_CRED_PSW
db_port=23300

drop_db() {
  envname="test-${1}"
  source <(grep "^DB_HOST=" .env.${envname})
  fullenv=$(echo "test-${1}-${BUILD_TAG}" | perl -pe 's/(-|%[[:xdigit:]]{2}|%)/_/g')
  sql_cmd "DROP DATABASE ${fullenv};"
  sql_cmd "DROP USER 'u${fullenv}'@'%';"
  rm .env.$envname
}

sql_cmd() {
  echo $* | mysql -u${db_user} -p${db_pass} -P ${db_port} -h ${DB_HOST}
}

for i in $(seq 1 $1);do
  drop_db $i && echo "Dropped db '${fullenv}' (for shortenv: $envname), user 'u${fullenv}': .env.$envname"
done

sql_cmd "FLUSH PRIVILEGES;"
