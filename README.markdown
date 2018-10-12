# FutureLearn SimpleSAMLPHP image 

This is a basic docker image that configures SimpleSAMLPHP to run as a
SAML IdP to use for local testing of SSO features.

## Dependencies

You'll need [Docker for Mac](https://docs.docker.com/docker-for-mac/) if
you're using a Mac. You can download the installer from docker, but it
wants a password, so alternatively use homebrew:

    $ brew cask install docker

## Starting the IdP

To run the IdP, clone this repo and run:

    $ docker-compose up

You can then view the web interface in your browser at
<http://localhost:9001/simplesaml>. The admin login is `admin / password`.
Shhhhhhh.

To stop the image, press ctrl-C in the docker-compose terminal.

To connect to the image for debugging:

    $ docker exec -it fl-simplesamlphp-dev_web_1 /bin/bash

If you make a change to any configuration files, stop the container and
rebuild it:

    $ docker-compose build

## Connecting from your rails server

To use the IdP from our app, you need to set up a
`SamlIdentityProvider`. There's a script to create an example one using
the right metadata for the IdP:

    $ ./script/create_saml_dev_idp.rb

This creates an identity provider record with ID 'fl-simplesamlphp-dev'
and attaches it to the "FL LM Demo" organisation.

With the IdP running, you can now try to authenticate by visiting
<http://localhost:3000/auth/saml/fl-simplesamlphp-dev>. This should take
you to the SimpleSAMLphp login UI, where you can log in as `joebloggs / password`.

You'll then be redirected back to the FutureLearn app, which will fail
to log you in because we haven't finished that code yet. But it's
progress, right? :-)
