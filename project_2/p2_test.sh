#!/bin/bash
TMP_DIR=/tmp/p2-grading/
REQUIRED_FILES="index.php sql/create.sql sql/load.sql"
ZIP_FILE=$1

# exit the script with the provided error message
function error_exit()
{
   echo "ERROR: $1" 1>&2
   rm -rf ${TMP_DIR}
   exit 1
}

# check if the given list of files exist
function check_files()
{
    for FILE in $1; do
        if [ ! -f ${FILE} ]; then
            error_exit "Cannot find ${FILE} in $2"
        fi
    done
}

# retrieve a file from a URL (first argument) and check its SHA1 (second argument)
# and save it in a directory (third argument) 
function retrieve_file()
{
    URL=$1
    SHA1=$2
    RETRIEVE_DIR=$3
    FILENAME=$(basename ${URL})
    if [ -z ${RETRIEVE_DIR} ]; then
        TESTFILE="${FILENAME}"
    else
        mkdir -p ${RETRIEVE_DIR}
        TESTFILE="${RETRIEVE_DIR}/${FILENAME}"
    fi

    # check whether the file has already been retrieved and exists
    if [ -f ${TESTFILE} ]; then
        sha1sum ${TESTFILE} | grep ${SHA1} &> /dev/null
        if [ $? -eq 0 ]; then
            # the file already exists and its checksum matches
            return
        fi
    fi

    # the file does not exist. retrieve the file
    curl -s ${URL} > ${TESTFILE}
    if [ $? -ne 0 ]; then
        error_exit "Failed to retrieve ${FILENAME} file"
    fi
    sha1sum ${TESTFILE} | grep ${SHA1} &> /dev/null
    if [ $? -ne 0 ]; then
        error_exit "Failed to retrieve ${FILENAME} file. Checksum mismatch."
    fi
}

# This code is for future reference in case we need to perform string matching
# RESULT1=`java ComputeSHA input.txt`
# RESULT2=`sha256sum ${INPUT_FILE} | awk '{print $1}'`

# if [ "$RESULT1" != "$RESULT2" ]; then
#         error_exit "ComputeSHA computes an incorrect SHA value."
# fi

# usage
if [ $# -ne 1 ]; then
     echo "Usage: $0 project2.zip" 1>&2
     exit
fi

if [ `whoami` != "cs143" ]; then
     error_exit "You need to run this script within the container"
fi

# clean any existing files
rm -rf ${TMP_DIR}
mkdir ${TMP_DIR}

# unzip the submission zip file 
if [ ! -f ${ZIP_FILE} ]; then
    error_exit "Cannot find $ZIP_FILE"
fi
unzip -q -d ${TMP_DIR} ${ZIP_FILE}
if [ "$?" -ne "0" ]; then 
    error_exit "Cannot unzip ${ZIP_FILE} to ${TMP_DIR}"
fi

# change directory to the grading folder
cd ${TMP_DIR}

# check the existence of the required files
check_files "${REQUIRED_FILES}" "root folder of the zip file"

# make sure that the load-file path is absolute, not relative
grep "/home/cs143/data" sql/load.sql &> /dev/null
if [ $? -ne 0 ]; then
    error_exit "Your load.sql file does not use absolute path for data-file locations"
fi

# drop existing tables
echo "Dropping existing tables in the cs143 database"
echo "drop table if exists Movie, Actor, Director, MovieGenre, MovieDirector, MovieActor, Review;" | mysql cs143

echo "Removing all files in /home/cs143/www/grading/"
rm -rf /home/cs143/www/grading
if [ $? -ne 0 ]; then
    error_exit "An error was encountered while cleaning up grading/ subdirectory"
fi

echo "Running your create.sql script..."
mysql cs143 < sql/create.sql
if [ $? -ne 0 ]; then
    error_exit "An error was encountered while running your create.sql file"
fi

echo "Running your load.sql script..."
mysql cs143 < sql/load.sql
if [ $? -ne 0 ]; then
    error_exit "An error was encountered while running your load.sql file"
fi

echo "Linking your submission to the grading/ subdirectory"
ln -sf ${TMP_DIR} /home/cs143/www/grading
if [ $? -ne 0 ]; then
    error_exit "An error was encountered while linking to grading/"
fi
echo "All done!"
echo ""
echo "Please ensure that you have a fully functional Web site available"
echo "at http://localhost:8888/grading/"
exit 0
