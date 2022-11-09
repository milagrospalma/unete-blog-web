FROM ubuntu:20.04
MAINTAINER Milagros Palma <mnpalma.2@gmail.com>

# ARG VDOMAIN_SERVER=altimeafactory.com

# Create default non-privileged user
# RUN useradd -ms /bin/bash altimea

# Install dependencies
RUN apt-get update
RUN apt-get -y install software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt-get -y install nano
RUN apt-get -y install php8.0
RUN apt-get -y install php8.0-cli php8.0-common php8.0-mysql php8.0-zip php8.0-gd php8.0-mbstring php8.0-curl php8.0-xml php8.0-bcmath php8.0-soap
RUN apt-get -y install supervisor
RUN apt-get -y install apache2 libapache2-mod-php8.0

#Environment variables to configure php
ENV PHP_UPLOAD_MAX_FILESIZE 10M
ENV PHP_POST_MAX_SIZE 10M
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Clean html folder (index
RUN rm -rf /var/www/html*

# Add required scripts
ADD altimeafactory/deploy.sh /deploy.sh
ADD altimeafactory/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod 755 /*.sh

# Configure apache
ADD altimeafactory/vhost.conf /etc/apache2/sites-available
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN echo "IncludeOptional vhost.conf" >> /etc/apache2/apache2.conf
RUN sed -i -e "s/{{ vdomain-server }}/${VDOMAIN_SERVER}/g" /etc/apache2/sites-available/vhost.conf
RUN rm /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite headers
RUN a2ensite vhost.conf

USER root
WORKDIR /

ADD app /var/www/html

EXPOSE 80
RUN chown -R altimea:altimea /var/www/html

CMD ["/usr/bin/supervisord", "-n"]

