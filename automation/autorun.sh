#/bin/bash


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

  `perl -e 'use $1'`
  if [ $? -eq 0] ; then
   return 1
  else
    return 0
  fi
}


#checkning the number of argument
if test $# -ne 1; then
 help_message
fi


#checkhing the provided argument
if test "$1" = "--help"  ; then
  echo "Usage : $0 devbox\nor : $0 prodbox"
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


#check the status of apache
status_apache
if [ $? -eq 1 ] ; then
   printf "apache is up\n"
  else
   printf "apache server is not up\n"
   exit 1
fi

#check the status of mysql
status_mysql
if [ $? -eq 1 ] ; then
   printf "mysql service is up\n"
  else
   printf "mysql service is not up\n"
   exit 1
fi

#check the status of perl module


