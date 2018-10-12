# FutureLearn SimpleSAMLPHP image

This is a basic docker image that configures SimpleSAMLPHP to run as a
SAML IdP to use for local testing of SSO features.

## Dependencies

You'll need [Docker for Mac](https://docs.docker.com/docker-for-mac/) if
you're using a Mac. If you're not, you, like... won't.

You can download the installer from docker, but it wants a password
(annoyingly), so alternatively:

    $ brew cask install docker

## Usage

To run the IdP:

    $ docker-compose up

You can then view the web interface in your browser at
<http://localhost:9001/simplesaml>. The admin login is `admin /
password`. Shhhhhhh.

To stop the image, ctrl-C in the docker-compose terminal.

To connect to the image for debugging:

    $ docker exec -it fl-simplesamlphp-dev_web_1 /bin/bash

If you make a change to any configuration files, stop the container and
rebuild it:

    $ docker-compose build
