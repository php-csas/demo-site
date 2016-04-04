#!/bin/bash

csas_enabled=true

# Parse command line arguments
# http://stackoverflow.com/questions/192249/how-do-i-parse-command-line-arguments-in-bash
while [[ $# > 1 ]]
do
key="$1"

case $key in
    -e|--enable_csas)
    ARG_CSAS_ENABLED="$2"
    ;;
    *)
            # unknown option
    ;;
esac
shift # past argument or value
done

# Parse the argument determining whether this demo will have csas enabled
if [ "ARG_CSAS_ENABLED" == 'n' ]; then
    csas_enabled=false
elif [ "ARG_CSAS_ENABLED" == 'y']; then
    csas_enabled=true
else
    csas_enabled=false
fi

command_exists () {
    type "$1" &> /dev/null ;
}

# Check if the appropriate commands exist
if ! command_exists vagrant ; then
    echo "Vagrant does not exist on this machine. The demonstration needs Vagrant to run the demonstration site. Aborting."
    exit 1
fi

if ! command_exists python ; then
    echo "Python does not exist on this machine. The demonstration needs Python for the XSS injection into the demonstration site to work. Aborting."
    exit 1
fi

if [ ${csas_enabled} = true ]; then
    echo "Provisioning machine for the first time"
    # cd csas && vagrant up
else
    echo "Provisioning machine for the first time"
    # cd no_csas && vagrant up
fi

while true; do
    if [ ${csas_enabled} = true ]
    then
        echo "Running demonstration with csas enabled"
        # Run the Python script to do the XSS injections
        # python run_demo.py --csas
        # Reboot the Vagrant machine when the demo is done
        # cd csas && vagrant reload
    else
        echo "Running demonstration without csas enabled"
        # Run the Python script to do the XSS injections
        # python run_demo.py --no_csas
        # Reboot the Vagrant machine when the demo is done
        # cd no_csas && vagrant reload
    fi
done

