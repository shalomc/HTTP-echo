#!/bin/bash

#        ******************************************************************************************************
#        *   Batch file to start an echo server in EC2 via CloudFormation                                     *
#        *   Set up the following:                                                                            *
#        *   1. The AWS CLI ( http://docs.aws.amazon.com/cli/latest/userguide/cli-chap-getting-set-up.html )  *
#        *   2. The default stack name is "echo"                                                              *
#        *   3. You *MUST* set up the SSHKEY variable                                                         *
#        *                                                                                                    *
#        ******************************************************************************************************

SSHKEY=someSSHkey
STACKNAME=echo
REGION=us-east-1

echo Stack being created...
STACKID=`aws cloudformation create-stack --stack-name $STACKNAME --region $REGION --template-body file://HttpEchoService.json --parameters ParameterKey=KeyName,ParameterValue=$SSHKEY --query 'StackId' --output text`


printf "StackID is: %s\n" "$STACKID" 
printf "Checking Stack creation every 10 seconds .....  \n"
StackResponse=`aws cloudformation describe-stacks --stack-name $STACKID --region $REGION  --query 'Stacks[0].[StackStatus,Outputs[0].OutputValue]' --output text`
StackResponseArr=( $StackResponse )
StackStatus=${StackResponseArr[0]}
while [ "$StackStatus" == "CREATE_IN_PROGRESS" ]
do
  printf "%s\n" "$StackStatus"
  sleep 10s
  StackResponse=`aws cloudformation describe-stacks --stack-name $STACKID --region $REGION  --query 'Stacks[0].[StackStatus,Outputs[0].OutputValue]' --output text`
  StackResponseArr=( $StackResponse )
  StackStatus=${StackResponseArr[0]}
done

StackOutput=${StackResponseArr[1]}
printf "%s - Echo URL is: %s\n" "$StackStatus" "$StackOutput" 
