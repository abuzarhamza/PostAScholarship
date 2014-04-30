#/bin/bash

#checkning the number of argument
if test $# -ne 1
 then
  echo "Try '$0 --help' for more information."
  exit 1
fi

#checkhing the provided argument
if test $1=="--help"
 then
  echo "Usage : $0 devbox\nor : $0 prod"
fi




