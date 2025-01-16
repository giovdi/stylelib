#!/bin/bash
increment_version() {
	local delimiter=.
	local array=($(echo "$1" | tr $delimiter '\n'))
	array[$2]=$((array[$2]+1))
	if [ $2 -lt 2 ]; then array[2]=0; fi
	if [ $2 -lt 1 ]; then array[1]=0; fi
	echo $(local IFS=$delimiter ; echo "${array[*]}")
}

LARAVELPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; cd ..; pwd -P )"

# VERSION
read -p "Version type [0=major, 1=minor, 2=build, empty to skip]: " VERSIONTYPE
if ([ -n "$VERSIONTYPE" ])
then
	VERP=$( grep -o -E "([0-9]+)\.([0-9]+)\.([0-9]+)" "$LARAVELPATH/stylelib/composer.json" )
	VERN=$( increment_version $VERP $VERSIONTYPE )
	sed -i "s/$VERP/$VERN/g" "$LARAVELPATH/stylelib/composer.json"
fi

# COMMIT & PUSH
read -p "Commit message [empty to skip]: " COMMITMSG
if ([ -n "$COMMITMSG" ])
then
	/usr/bin/git add .
	/usr/bin/git commit -m $COMMITMSG
	/usr/bin/git push
	/usr/bin/git tag -a v$VERN -m "version $VERN"
	/usr/bin/git push origin tag v$VERN
fi