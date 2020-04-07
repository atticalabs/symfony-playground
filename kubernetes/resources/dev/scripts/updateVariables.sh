echo \#\#\#Setting up enviroment\#\#\#
cd ../../../../ #Moving to root folder of project
#Getting absolute path of root
export WORK_DIR=$(pwd)
#Directory name where public web server is located
export PUBLIC_DIR="$WORK_DIR/public"
#Key to search into yaml
export PREFIX='localVolume'
#Building the value to write into yaml backend file
export BE_VALUE_TO_PUT="$PREFIX: $WORK_DIR" 
#Building the value to write into yaml web server file
export WEB_VALUE_TO_PUT="$PREFIX: $PUBLIC_DIR" 
#Finding the lines thats start with the provided key name
export PATTERN_TO_REPLACE="$PREFIX:.*" 

#To validate the values to use in the transaction
echo Seetting up backend services
echo ENV: $WORK_DIR
echo VALUE BE:  $BE_VALUE_TO_PUT
echo VALUE WEB: $WEB_VALUE_TO_PUT
echo PATTERN: $PATTERN_TO_REPLACE
echo PUBLIC DIRECTORY : $PUBLIC_DIR
echo 
#Command to find and replace into backend values
sed -i "s|$PATTERN_TO_REPLACE|$BE_VALUE_TO_PUT|g" './kubernetes/resources/dev/services/backend/values.yaml'
if [ $? -eq 0 ]; then
    echo Backend values up to date!
else
    echo Fail \while setting up the values to backend service.
fi

#Command to find and replace into web server values
sed -i "s|$PATTERN_TO_REPLACE|$WEB_VALUE_TO_PUT|g" './kubernetes/resources/dev/services/web-server/values.yaml'
if [ $? -eq 0 ]; then
    echo Web server values up to date!
else
    echo Fail \while setting up the values to web server service.
fi