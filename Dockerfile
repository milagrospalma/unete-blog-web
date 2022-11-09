FROM ubuntu:20.04
MAINTAINER Milagros Palma <mnpalma.2@gmail.com>

# ARG VDOMAIN_SERVER=uneteabelcorp.com

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
RUN apt-get -y install apache2 libapache2-mod-php8.0
RUN apt-get update
RUN apt-get install curl
RUN apt-get install tar

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
ADD /deploy.sh /deploy.sh
RUN chmod 755 /*.sh


# Configure apache
ADD vhost.conf /etc/apache2/sites-available
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN echo "IncludeOptional vhost.conf" >> /etc/apache2/apache2.conf
RUN sed -i -e "s/{{ vdomain-server }}/${VDOMAIN_SERVER}/g" /etc/apache2/sites-available/vhost.conf
RUN rm /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite headers
RUN a2ensite vhost.conf
RUN mkdir -p /var/log/apache2/ && touch /var/log/apache2/access.log && ln -sf /proc/1/fd/1 /var/log/apache2/access.log
RUN mkdir -p /var/log/apache2/ && touch /var/log/apache2/error.log && ln -sf /proc/1/fd/2 /var/log/apache2/error.log

USER root

RUN \
  curl -L https://download.newrelic.com/php_agent/release/newrelic-php5-9.18.1.303-linux.tar.gz | tar -C /tmp -zx && \
  export NR_INSTALL_USE_CP_NOT_LN=1 && \
  export NR_INSTALL_SILENT=1 && \
  /tmp/newrelic-php5-*/newrelic-install install && \
  rm -rf /tmp/newrelic-php5-* /tmp/nrinstall* && \
  sed -i \
      -e 's/"REPLACE_WITH_REAL_KEY"/"86eef6eb515d668f7d5737da0154f9e74e53531d"/' \
      -e 's/newrelic.appname = "PHP Application"/newrelic.appname = "ODP_BlogUnete_QAS"/' \
      -e 's/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout=15s/' \
      -e 's/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout=5s/' \
      /etc/php/8.0/apache2/conf.d/newrelic.ini

WORKDIR /

ADD app /var/www/html

EXPOSE 80
RUN chown -R www-data:www-data /var/www
CMD bash -c "/usr/sbin/apache2 -D FOREGROUND && /etc/init.d/newrelic-daemon start"