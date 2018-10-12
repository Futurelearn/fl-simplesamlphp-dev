# FutureLearn SimpleSAMLPHP image 

This is a basic docker image that configures SimpleSAMLPHP to run as a
SAML IdP to use for local testing of SSO features.

## Dependencies

You'll need [Docker for Mac](https://docs.docker.com/docker-for-mac/) if
you're using a Mac. You can download the installer from docker, but it
wants a password, so alternatively use homebrew:

    $ brew cask install docker

Launch the Docker app to install the required tools, such as `docker-compose`.

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

## Configuring the IdP

Configuration is all in `var-simplesamlphp`, and is copied to the image
at build time, so any changes to the configuration require the container
to be rebuilt as described above.

To set up the IdP we followed the [SimpleSAMLphp installation
guidelines](https://simplesamlphp.org/docs/stable/simplesamlphp-install#section_8)
(starting from the `config.php` section), then used the [Identity
Provider
QuickStart](https://simplesamlphp.org/docs/stable/simplesamlphp-idp)
docs to enable the IdP.

We're using the `exampleauth` module to provide the list of user
accounts for the IdP - new users can be added by editing
`var-simplesamlphp/config/authsources.php` and finding the
`example-userpass` section.
