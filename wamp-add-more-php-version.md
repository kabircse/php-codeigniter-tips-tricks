How To Install PHP 5.3.5 on WAMP
==========================================
The latest PHP version provided by WAMP is currently PHP 5.5. Continue reading if you want to install another php version.

I successfully installed PHP 5.3.5 on my WAMP server under Windows 7 32 bit. 
But this short tutorial will probably work on other versions as well.

Go to the [Windows download page at PHP.net][1] and download the desired version. 
You must select the ZIP VC6 x86 Thread Safe variant.

Unpack the contents to the PHP bin directory in your WAMP installation. 
I unpacked PHP 5.3.5 in ```C:\wamp\bin\php\php5.3.5\.```

You should now copy the following files from the php5.3.0 directory, to your newly created directory (php5.3.5 in my case): 
```
php.ini, phpForApache.ini, wampserver.conf.
```

Now we just need to make a quick edit in both INI-files. 
Search for ```5.3.0``` and replace it with the PHP version you are installing.

Save the files, and you should see the new version in the PHP version menu in WAMP. 
If not, right-click the WAMP icon and choose "Exit", then start it again.
[1]:http://windows.php.net/downloads/releases/archives/
