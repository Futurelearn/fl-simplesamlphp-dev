# FutureLearn SimpleSAMLPHP image

This is a basic docker image that configures SimpleSAMLPHP to run as a
SAML IdP to use for local testing of SSO features.

## Usage

To fetch the base image:

    docker pull centos:centos7

To build the image:

    docker build --tag="futurelearn/simplesamlphp-idp:0.0.1" .

To run the image:

    docker run -P -d --rm --name="ssp-local-test" futurelearn/simplesamlphp-idp:0.0.1

To log on to the image for debugging:

    docker exec -it ssp-local-test /bin/bash
