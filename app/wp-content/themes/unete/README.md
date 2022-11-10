
# Theme Unete


### APACHE
Configuracion basica del virtualhost modo desarrollador en: ` /etc/apache2/sites-available/local.project.com.conf`

	<VirtualHost *:80>
		ServerName local.project.com
		DocumentRoot /var/www/html/project/app/
		<Directory /var/www/html/project/app/>
			Options Indexes FollowSymLinks Multiviews
			AllowOverride All
			Order allow,deny
			allow from all
			RewriteEngine on
		</Directory>
		SetEnv WP_ENV dev
		ErrorLog ${APACHE_LOG_DIR}/local.project.com-error.log
	</VirtualHost>
