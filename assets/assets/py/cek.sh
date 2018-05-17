#!/bin/bash

# Check if gedit is running
# -x flag only match processes whose name (or command line if -f is
# specified) exactly match the pattern. 
x=`pgrep -x "motion"`
echo $x
while [ $x >/dev/null ] 
do
    echo "Running"
    sudo kill $x
    x=`pgrep -x "motion"`
    #sudo service motion stop
done
    echo "Stopped"
    #sudo service motion start

