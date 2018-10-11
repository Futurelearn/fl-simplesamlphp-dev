FROM unicon/simplesamlphp

MAINTAINER simon.coffey@futurelearn.com

COPY etc-httpd/ /etc/httpd/
COPY var-simplesamlphp/ /var/simplesamlphp/
COPY var-www/ /var/www/
