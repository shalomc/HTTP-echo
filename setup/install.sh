#!/bin/bash

# You need php54. Uninstall the 
# yum -y install php54
# yum -y install git
# git clone https://github.com/shalomc/HTTP-echo.git

yes | cp /tmp/HTTP-echo/setup/echo.conf /etc/httpd/conf.d/

yes | cp -R /tmp/HTTP-echo/* /var/www/html/
yes | cp /tmp/HTTP-echo/.htaccess /var/www/html/
yes | rm /etc/httpd/conf.d/welcome.conf
yes | rm /var/www/html/setup/*
service httpd restart
