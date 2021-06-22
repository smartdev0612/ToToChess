

@@@ /home/httpd/vhost.smile-korea/www/index.php is created successfully! @@@

/home/httpd/vhost.smile-korea/EzApp/www/App/Controller -> directory created.
/home/httpd/vhost.smile-korea/EzApp/www/App/Model -> directory created.
/home/httpd/vhost.smile-korea/EzApp/www/config -> directory created.
Base ini file is copied in /home/httpd/vhost.smile-korea/EzApp/www/config 
/home/httpd/vhost.smile-korea/EzApp/www/lib -> directory created.
/home/httpd/vhost.smile-korea/www//_template -> directory created.
/home/httpd/vhost.smile-korea/www//_compile -> directory created.
/home/httpd/vhost.smile-korea/www//_cache -> directory created.

Check above directories. If any directory is not exists, make the directory manually.
Check ini file in /home/httpd/vhost.smile-korea/EzApp/www/config. If ini file not exists, copy ini file manually.

==================================================================================================
<<< IMPORTANT!! README >>>

1. Input follow 2-line in Your apache's vhost configuration

RewriteEngine on
RewriteRule !\.(js|ico|gif|jpg|png|css|wav|mid|mp3|mov|avi|mpeg|mpg|wmv|asx|asf)$ /home/httpd/vhost.smile-korea/www/index.php [NC]

2. Set your php.ini's 'include_path' (if EzApp's source path is '/home/httpd/EzApp' ...)

include_path='/home/httpd'

3. Restart apache server
==================================================================================================

