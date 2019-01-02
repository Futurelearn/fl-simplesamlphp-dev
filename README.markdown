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

You'll then be redirected back to the FutureLearn app, where the log in 
process will continue with several different outcomes depending on the status 
of the organisation membership from the "FL LM Demo" organisation: check
the example instructions for creating a new user in FL via SSO below.

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

## Integration with the FutureLearn app - Example instructions for QA of registration of a new FL user via SSO

- **run the simple saml php service**
- open a console at fl-simplesamlphp-dev
- run the service with `docker-compose up`

- **set up the demo organisation in FL locally**
- download a fresh copy of the staging DB with `bundle exec cap staging db:import` (or is there a better `fligo` way now?)
- create the demo IdP running the script `./script/create_saml_dev_idp.rb`

- **invite the demo learner to courses from the demo organisation**
- run the rails server
- visit LM at http://localhost:3000/learning-manager with your admin account
- choose the organisation `FL LM Demo`
- click on `invite learners to a course`
- select a course
- invite by email `joe@example.com`

- **now test the registration via SSO**
- open a MySQL console: `bundle exec rails db -p`
- check that the new pending organisation_membership has been created successfully for joe@example.com:
-- `select * from organisation_memberships order by created_at desc limit 1;`
-- the fields: `learner_id`, `accepted_at`, and `acceptance_method` should all be `NULL`
-- keep the mysql console open to verify the membership later
- open a Guest browser window
- visit http://localhost:3000/auth/saml/fl-simplesamlphp-dev
- log on with the org credentials: joebloggs / password
- once redirected on FL, choose `Not yet joined? **Register**`
- register the new user, making sure to be enabling SAML
- you should be now logged on 
- you should have a notification with the course invitation from FL LM Demo
- the organisation_membership should now be updated:
-- `select * from organisation_memberships order by created_at desc limit 1;`
-- the fields: `learner_id`, `accepted_at`, and `acceptance_method` should all be filled, and the `acceptance_method` now set to `saml`
