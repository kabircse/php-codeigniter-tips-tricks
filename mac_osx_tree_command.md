Save the following script to /usr/local/bin/tree
```
#!/bin/bash

SEDMAGIC='s;[^/]*/;|____;g;s;____|; |;g'

if [ "$#" -gt 0 ] ; then
   dirlist="$@"
else
   dirlist="."
fi

for x in $dirlist; do
     find "$x" -print | sed -e "$SEDMAGIC"
done
```
```chmod 755 /usr/local/bin/tree```

and enjoy

Of course you may have to create ```/usr/local/bin```
