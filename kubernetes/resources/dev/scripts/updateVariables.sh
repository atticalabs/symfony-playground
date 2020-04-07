echo \#\#\#Setting up enviroment\#\#\#
cd ../../../../ #Moving to root folder of project
#Getting absolute path of root
export WORK_DIR=$(pwd)
#Key to search into yaml
export PREFIX='localVolume'
#Building the value to write into yaml file
export VALUE_TO_PUT="$PREFIX: $WORK_DIR" 
#Finding the lines thats start with the provided key name
export PATTERN_TO_REPLACE="$PREFIX:.*" 

#To validate the values to use in the transaction
echo Seetting up backend services
echo ENV: $WORK_DIR
echo VALUE:  $VALUE_TO_PUT
echo PATTERN: $PATTERN_TO_REPLACE 
echo 
#Command to find and replace
sed -i "s|$PATTERN_TO_REPLACE|$VALUE_TO_PUT|g" './kubernetes/resources/dev/services/backend/values.yaml'
if [ $? -eq 0 ]; then
    echo Success
else
    echo Fail \while setting up the values to backend service.
fi