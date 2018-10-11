# FutureLearn SimpleSAMLPHP image

This is a basic docker image that configures SimpleSAMLPHP to run as a
SAML IdP to use for local testing of SSO features.

## Dependencies

You'll need [Docker for Mac](https://docs.docker.com/docker-for-mac/) if
you're using a Mac. If you're not, you, like... won't.

## Usage

To fetch the base image:

    docker pull centos:centos7

To build the image:

    docker build --tag="futurelearn/simplesamlphp-idp:0.0.1" .

To run the image:

    docker run -p 0.0.0.0:9001:80 -d --rm --name="ssp-local-test" futurelearn/simplesamlphp-idp:0.0.1

You can then view the web interface in your browser at
<http://localhost:9001/simplesaml>. The admin login is `admin /
password`. Shhhhhhh.

To stop the image

    docker kill ssp-local-test

To log on to the image for debugging:

    docker exec -it ssp-local-test /bin/bash
