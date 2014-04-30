#/bin/bash


help_message() {
  echo "Try '$0 --help' for more information."
  exit 1
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

case $BOX_ENV in
   "devbox")
            ;;

   "prodbox")
             ;;

   *) help_message ;;
esac

