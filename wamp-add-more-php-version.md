How To Install PHP 5.3.5 on WAMP
==========================================
The latest PHP version provided by WAMP is currently PHP 5.5. This may help if you want to install another php version.

I have installed PHP 5.3.5 on my WAMP server under Windows 7 32 bit successfully, and maybe It works for your situation.

First of all, you need to download php version that you need to install, just got to  [Windows download page at PHP.net][1] for download. 
You have to choice the ZIP VC6 x86 Thread Safe package.

Unpack the contents to the PHP bin directory in your WAMP installation. 
I have unpacked PHP 5.3.5 in ```C:\wamp\bin\php\php5.3.5\.```

Then You need to copy the following files from the php5.3.0 directory, to your newly created directory (php5.3.5, php5.x.x ... etc): 
```
php.ini, phpForApache.ini, wampserver.conf.
```

Now we just need to make a quick edit in both INI-files. 
Search for ```5.3.0``` and replace it with the PHP version you are installing.

Save the files, and you should see the new version in the PHP version menu in WAMP. 
If not, right-click the WAMP icon and choose "Exit", then start it again.
[1]:http://windows.php.net/downloads/releases/archives/
