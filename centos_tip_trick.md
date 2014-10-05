http://www.shayanderson.com/linux/centos-5-or-centos-6-upgrade-php-to-php-54-or-php-55.htm
https://webtatic.com/packages/php55/

**This article describes how to upgrade to PHP 5.4 or PHP 5.5 on a CentOS 5 or CentOS 6 server.**
    First, detect if any PHP packages are installed:
    ```
    # yum list installed | grep php
    ```
    If packages are installed remove them, for example:
    ```
    # yum remove php.x86_64 php-cli.x86_64 php-common.x86_64 php-gd.x86_64 php-ldap.x86_64 php-mbstring.x86_64 php-mcrypt.x86_64 php-mysql.x86_64 php-pdo.x86_64
    ```
    Add PHP 5.4 packages to yum using this command for CentOS 5.x
    ```
    # rpm -Uvh http://mirror.webtatic.com/yum/el5/latest.rpm
    ```
    Or, for CentOS 6.x:
    ```
    # rpm -Uvh http://mirror.webtatic.com/yum/el6/latest.rpm
    ```
    Now, you can check if the new PHP (5.4: php54w or 5.5: php55w) packages are available:
    ```
    # yum list available | grep php
    ``` 
    Or, version specific search:
    ```
    # yum list available | grep php54
    ```
    Next, install the new PHP 5.4 or 5.5 packages, for example when installing PHP 5.4 packages I used:
    ```
    # yum install php54w.x86_64 php54w-cli.x86_64 php54w-common.x86_64 php54w-gd.x86_64 php54w-ldap.x86_64 php54w-mbstring.x86_64 php54w-mcrypt.x86_64 php54w-mysql.x86_64 php54w-pdo.x86_64
    ```
    PHP should now be upgraded to the new version, you can verify with the command:
    ```
    # php -v
    ```
    PHP 5.4.17 (cli) (built: Jul 23 2013 00:02:04)
    Copyright (c) 1997-2013 The PHP Group
    Zend Engine v2.4.0, Copyright (c) 1998-2013 Zend Technologies
    Finally, restart the Web server: # service httpd restart
    

You can confirm that mysqli is installed, or not, by listing the installed modules. SSH into your Cent OS box, and issue the following command.

```php -m | grep mysqli```

If nothing is returned, then you do not have mysqli.so loaded. Check if you have the shared object is installed on you system.

# Located extension dir
```php -i | grep extension_dir```
# List mysql.so in the path returned from the previous command
``ls -la /usr/lib/php/extensions/no-debug-non-zts-20090626/mysqli.so```

If the mysqli.so is present, and has the permissions -rwxr-x-rx, you'll need to load/enable the mysqli extension in the systems global php.ini file.

# Adjust path to correct php.ini file. 
# Run `php -i | grep "Configuration File"` to locate, if needed
# It might be easier to use vi, or nano, for this
```sudo echo "extension=mysqli.so" >> /etc/php5/php.ini```
# Restart apache
```sudo service httpd restart```

Else. If you do not have mysqli.so present in your system. You can install the rpm by following your systems package manager, and repeating the previous php.ini step.

```sudo yum install php5-mysqli```


