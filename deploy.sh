#!/usr/bin/env bash

# Fix permissions
chown www-data:www-data -R /var/www/html

# Start Apache
service apache2 start
service apache2 restart