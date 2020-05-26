@echo off

rem        ******************************************************************************************************
rem        *   Batch file to start an echo server in EC2 via CloudFormation                                     *
rem        *   Set up the following:                                                                            *
rem        *   1. The AWS CLI ( http://docs.aws.amazon.com/cli/latest/userguide/cli-chap-getting-set-up.html )  *
rem        *   2. The default stack name is "echo"                                                              *
rem        *   3. You *MUST* set up the SSHKEY variable                                                         *
rem        *                                                                                                    *
rem        ******************************************************************************************************

set SSHKEY=someSSHkey
set STACKNAME=echo
set REGION=us-east-1
set PROFILE=sandbox

echo Stack being created...
aws cloudformation create-stack --profile %PROFILE% --stack-name %STACKNAME% --region %REGION% --template-body file://HttpEchoService.json --parameters ParameterKey=KeyName,ParameterValue=%SSHKEY% --query "StackId" --output text  > @tmpfile
set /p STACKID=<@tmpFile
del @tmpFile 
ECHO Stack ID: %STACKID%
echo.
echo Follow progress on the CloudFormation console 
echo.
echo "https://console.aws.amazon.com/cloudformation/home?region=%REGION%#/stacks?filter=active&tab=outputs&stackId=%STACKID%"

