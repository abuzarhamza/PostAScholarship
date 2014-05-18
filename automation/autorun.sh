#/bin/bash
###################################
###################################
###################################
#PLZ RUN THE AUTO SCRIPT AS ROOT

###################################
#TO DO
#1.write script to create tag of db into xml for (ajax)
#2.automation for insertion of badge
#3.log file integreation
###################################


help_message () {
  echo "Try '$0 --help' for more information."
  exit 1
}

status_apache () {
  testrun "$XAMPP_ROOT/logs/httpd.pid" httpd
  if  [ $? -eq 1 ] ; then
    return 1
   else
    return 0
  fi
}

status_mysql () {

  testrun "$XAMPP_ROOT/var/mysql/$(hostname).pid" mysqld
  if [ $? -eq 1 ] ; then
     return 1
    else
     return 0
  fi
}

testrun () {
  if test -f $1 ; then
      pid=`cat $1`
      if ps ax 2>/dev/null | egrep "^ *$pid.*$2" > /dev/null; then
          return 1
         else
          return 0
      fi
  else
    return 0
  fi
}

check_perlmodule() {

  perl -e "use $1" 2>/dev/null
  if [ $? -ne 0 ] ; then
    return 0
  fi
  return 1
}


#checking the number of argument
if test $# -ne 1; then
 help_message
fi


#checking the provided argument
if test "$1" = "--help"  ; then
  echo "Usage : $0 devbox\n   or : $0 prodbox"
  exit 1
fi

if [ "$(id -u)" != "0" ]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi


BOX_ENV=$1
XAMPP_ROOT=""

#checking the provided argumant || can remove the above if
case $BOX_ENV in
   "devbox")
            XAMPP_ROOT="/opt/lampp"
            ;;

   "prodbox")
             ;;

   *) help_message ;;
esac

###############################
#test for service status
###############################
#check the status of apache
status_apache
returnVal=$?
if [ $returnVal -eq 1 ] ; then
   printf "Status : apache is up\n"
  else
   printf "Status : apache server is not up\n"
   exit 1
fi

#check the status of mysql
status_mysql
returnVal=$?
if [ $returnVal -eq 1 ] ; then
   printf "Status : mysql service is up\n"
  else
   printf "Status : mysql service is not up\n"
   exit 1
fi

echo "Staus : Process Id of the script : $$"
###############################
#pre-requsite module for perl
###############################

PERL_MODULE="DBI DBD::mysql Smart::Comments"
#check the status of perl module
for modName in $PERL_MODULE ; do
  check_perlmodule $modName
  returnVal=$?
  if [ $returnVal -ne 1 ] ; then
    echo "Error msg : perl module \`$modName\` is not installed ";
    exit 1
   else
    echo "Status : perl module \`$modName\` is installed ";
  fi
done

###############################
#table and proc fucntion creation
###############################

#running the db setup
echo "Status : creating the table"
perl /opt/lampp/htdocs/PostAScholarship/automation/perl/script/dbAutomation.pl >/dev/null

if [ $? -ne 0 ] ; then
  echo "Error msg : Error occured for the \`dbAutomation.pl\` script"
fi

# ###############################
# #paring the sql file for comments
# ###############################

sqlFileName="/opt/lampp/htdocs/PostAScholarship/mysql/plsql/admin/StoreProc.sql"
tempSqlFileName="/tmp/$$.sql"

# echo  "$tempSqlFileName"

if  [ ! -e $sqlFileName ] ; then
  echo "Error msg :  file $sqlFileName not present"
  exit 1
fi #<-- this bug wasted my 1 hour


while IFS= read -r line ; do
  echo "$line"
  echo "$line" | grep -v "^--" >> $tempSqlFileName
done <"$sqlFileName"



if [ ! -e $tempSqlFileName ] ; then
  echo "Error : file $tempSqlFileName not present"
  exit 1
fi

echo "Status : $tempSqlFileName has been created"


/opt/lampp/bin/mysql --user=root --password="" --database="postascholarship_db" < $tempSqlFileName > /dev/null

if [ $? -ne 0 ] ; then
  echo "Error msg : Error occured for the \`$tempSqlFileName\` script"
 else
  echo "Status : creating the procedure and function from $tempSqlFileName"
fi

tagSqlFileName="/opt/lampp/htdocs/PostAScholarship/mysql/Tag.sql"
echo "Status : inserting tag into db"
if [ ! -e $tagSqlFileName ] ; then
  echo "Error : file cant be found \`$tagSqlFileName\`"
  exit 1
fi

/opt/lampp/bin/mysql --user=root --password="" --database="postascholarship_db" < $tagSqlFileName

if [ $? -ne 0 ] ; then
    echo "Error msg : Error occured for the \`$tagSqlFileName\` script"
  else
    echo "Status : inserted the tag from $tagSqlFileName"
fi
