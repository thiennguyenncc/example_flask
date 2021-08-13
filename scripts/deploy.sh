#!/bin/bash
case "$1" in
  "dev-healthcheck"):
    SSH_USER=ec2-user
    SSH_URL=new-dev.bachelorapp.net
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy healthcheck $@'"
    ;;
  "prod-bk-healthcheck"):
    SSH_USER=ec2-user
    SSH_URL=new-backup.bachelorapp.net
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy healthcheck $@'"
    ;;
  "prod-healthcheck"):
    SSH_USER=ec2-user
    SSH_URL=new.bachelorapp.net
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy healthcheck $@'"
    ;;
	"dev"):
    SSH_USER=ec2-user
    SSH_URL=new-dev.bachelorapp.net
    [ -z "$2" ] && BRANCH=dev || BRANCH=$2
    # SSH into box and deploy
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy $1 $BRANCH'"
		;;
	"dev-wk"):
    SSH_USER=ec2-user
    SSH_URL=new-dev.bachelorapp.net
    [ -z "$2" ] && BRANCH=dev || BRANCH=$2
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy $1 $BRANCH'"
		;;
	"test"):
    SSH_USER=ec2-user
    SSH_URL=new-test.bachelorapp.net
    [ -z "$2" ] && BRANCH=dev || BRANCH=$2
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy $1 $BRANCH'"
		;;
	"test-wk"):
    SSH_USER=ec2-user
    SSH_URL=new-test.bachelorapp.net
    [ -z "$2" ] && BRANCH=dev || BRANCH=$2
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy $1 $BRANCH'"
		;;
	"stg"):
    SSH_USER=ec2-user
    SSH_URL=new-stg.bachelorapp.net
    [ -z "$2" ] && BRANCH=dev || BRANCH=$2
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy $1 $BRANCH'"
		;;
	"stg-wk"):
    SSH_USER=ec2-user
    SSH_URL=new-stg.bachelorapp.net
    [ -z "$2" ] && BRANCH=dev || BRANCH=$2
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy $1 $BRANCH'"
		;;
	"prod-bk"):
    SSH_USER=ec2-user
    SSH_URL=new-backup.bachelorapp.net
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy prod-bk'"
		;;
	"prod"):
    SSH_USER=ec2-user
    SSH_URL=10.20.12.114
    ssh -t $SSH_USER@$SSH_URL "bash -lci 'bdeploy prod'"
		;;
esac
