**Error Logging via the HTAccess file
Step 1: Create a log file
Create an empty file called “php-errors.log”. This file will serve as your site’s PHP error log. Your server will need write access to this file, so make sure to set the appropriate permissions. This file may be placed in any directory, but placing it above the web-accessible root directory of your site is advisable for security reasons. Once this file is created, writable, and in place, take note of its absolute directory path and continue to the final step.

Step 2: Add the magic code
Next, open your site’s root .htaccess file and add the following code:
**

# PHP error handling for production servers

# disable display of startup errors
php_flag display_startup_errors off

# disable display of all other errors
php_flag display_errors off

# disable html markup of errors
php_flag html_errors off

# enable logging of errors
php_flag log_errors on

# disable ignoring of repeat errors
php_flag ignore_repeated_errors off

# disable ignoring of unique source errors
php_flag ignore_repeated_source off

# enable logging of php memory leaks
php_flag report_memleaks on

# preserve most recent error via php_errormsg
php_flag track_errors on

# disable formatting of error reference links
php_value docref_root 0

# disable formatting of error reference links
php_value docref_ext 0

# specify path to php error log
php_value error_log /home/path/public_html/domain/PHP_errors.log

# specify recording of all php errors
# [see footnote 3] # php_value error_reporting 999999999
php_value error_reporting -1

# disable max error string length
php_value log_errors_max_len 0

# protect error log by preventing public access
<Files PHP_errors.log>
 Order allow,deny
 Deny from all
 Satisfy All
</Files>
