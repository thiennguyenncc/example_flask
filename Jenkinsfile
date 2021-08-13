def project_name = "${env.JOB_NAME}".replace("%2F", "/")

node {
  checkout([
    $class: 'GitSCM',
    extensions: scm.extensions + [[$class: 'CloneOption', reference: '/var/lib/gitcache/bachelor-backend.git']],
    branches: scm.branches,
    userRemoteConfigs: scm.userRemoteConfigs,
  ])
}

pipeline {
  agent any

  options {
    buildDiscarder(logRotator(numToKeepStr: '100'))
  }

  stages {

    // Step 1. Install Dependencies
    stage('Install Project Dependencies') {
      parallel {
        stage('Notify slack') {
          steps {
            slackSend channel: 'chatops', message: "${project_name} - #${env.BUILD_NUMBER} Started build (<${env.RUN_DISPLAY_URL}|Open>)"
          }
        }

        stage('install php deps') {
          steps {
            sh 'composer install -n --no-ansi'
            // Delete any .gitignores that got includes as part of composer packges
            // These might interefere with our --exclude-vcs-ignores option in the build stage
            sh 'find vendor -name ".gitignore" -exec rm -v {} ";"'
          }
        }

        stage('install npm deps') {
          steps {
            sh 'npm install'
          }
        }
      }
    }

    // Step 2. Package Code into distribution tarball
    stage('Build Tarball') {
      steps {
        sh '''BRANCH="$(echo ${GIT_BRANCH} | tr \'/\' \'_\' | cut -d \'_\' -f 2-)"
TREEISH="$(echo ${GIT_COMMIT} | cut -c 1-6)"
FN="bachelor-backend-v1-b${BUILD_NUMBER}-${BRANCH}@${TREEISH}.tar.xz"
echo "building ${FN}"

#build deployable archive:
export XZ_OPT="-3 -T2"
tar --exclude-vcs --exclude-vcs-ignores -cJf "/tmp/${FN}" -C "${WORKSPACE}" .
mv "/tmp/${FN}" .'''
      }
    }

    stage('Archive and Upload') {
      steps {
        s3Upload consoleLogLevel: 'INFO', dontWaitForConcurrentBuildCompletion: false, dontSetBuildResultOnFailure: false, entries: [[bucket: 'builds', excludedFile: '', flatten: false, gzipFiles: false, keepForever: false, managedArtifacts: true, noUploadOnFailure: true, selectedRegion: 'xvolve-internal-1', showDirectlyInBrowser: false, sourceFile: '*xz', storageClass: 'STANDARD', uploadFromSlave: true, useServerSideEncryption: false, userMetadata: [[key: 'branch', value: '${GIT_BRANCH}'], [key: 'treeish', value: '${GIT_COMMIT}'], [key: 'build-number', value: '${BUILD_NUMBER}'], [key: 'project', value: '${JOB_NAME}']]]], pluginFailureResultConstraint: 'FAILURE', profileName: 'xvolve-internal-1', userMetadata: []
      }
    }

    stage('Prepare For Testing') {
      environment {
        TESTDB_CRED = credentials('dlsgmaria-maint-user')
      }
      steps {
        sh './scripts/ci/create-temp-dbs.sh 15'
        sh 'mkdir junit'
      }
    }

    stage('Test') {
      parallel {
       stage('[behat] Default') {
             steps {
               warnError('Default Suite ran unsuccessfully 🤕') {
                 sh 'php artisan migrate:fresh --seed --env=test-1'
                 sh 'APP_ENV=test-1 ./vendor/bin/behat -f pretty -o storage/logs/behat-default.log -f junit -o junit/1 -f cucumber_json -o junit/1 -s default --no-snippets --verbose=2 --no-colors'
            }
          }
        }
      }
    }

    stage('Testing Cleanup') {
      environment {
        TESTDB_CRED = credentials('dlsgmaria-maint-user')
      }
      steps {
        sh './scripts/ci/drop-temp-dbs.sh 15'
        archiveArtifacts(artifacts: 'storage/logs/*', fingerprint: true)
        livingDocs(featuresDir:'junit')
      }
    }
  }

  post {
    success {
      slackSend channel: 'chatops', color: 'good', message: "${project_name} - #${env.BUILD_NUMBER} Build Success (<${env.RUN_DISPLAY_URL}|Open>). Took ${currentBuild.durationString}.\nChanges: \n$changeString"
    }
    unstable {
      slackSend channel: 'chatops', color: 'warning', message: "${project_name} - #${env.BUILD_NUMBER} Build Completed, UNSTABLE (<${env.RUN_DISPLAY_URL}|Open>). Took ${currentBuild.durationString}.\nChanges: \n$changeString"
    }
    failure {
      slackSend channel: 'chatops', color: 'danger', message: "${project_name} - #${env.BUILD_NUMBER} Build Failure (<${env.RUN_DISPLAY_URL}|Open>). Took ${currentBuild.durationString}.\nChanges: \n$changeString"
    }
    always {
      junit 'junit/**/*.xml'
      cucumber buildStatus: 'UNSTABLE',
        fileIncludePattern: 'junit/**/report*.json',
        sortingMethod: 'ALPHABETICAL',
        trendsLimit: 100
      cleanWs()
    }
  }

}

@NonCPS
def getChangeString() {
    MAX_MSG_LEN = 100
    def changeString = ""
    echo "Gathering SCM changes"
    def changeLogSets = currentBuild.rawBuild.changeSets
    for (int i = 0; i < changeLogSets.size(); i++) {
        def entries = changeLogSets[i].items
        for (int j = 0; j < entries.length; j++) {
            def entry = entries[j]
            truncated_msg = entry.msg.take(MAX_MSG_LEN)
            changeString += " - ${truncated_msg} [${entry.author}]\n"
        }
    }
    if (!changeString) {
        changeString = " - No new changes"
    }
    return changeString
}
