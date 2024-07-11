# CarRentalApi

Before Starting please Checkout to the Develop Branch and enter in CarRental folder which contains the project code source
```
git checkout develop
cd CarRental
```

NB: the project Has MakeFile that has all the necessary Commands that you will need

## Requirements
- php >= 8.1
- Symfony CLI
- mysql
- composer

#### Preparing the environment
* Copy .env to .env.local
* Change Variables

#### Installation

run the following command will install all dependencies and create the database and run fixtures that you will need for testing:
```
make init
```
#### Running Project
check that the port 8000 is available  and run:
```
make start
```

#### Use Instructions:
all Apis needs a Bearer token so you need to :
- call the authentication API "api/login_check" and use the token provided
you can use the credentials in test file

* JWT Change Variables

|    Variable    | 
|:--------------:|
| JWT_SECRET_KEY |
| JWT_PUBLIC_KEY |
| JWT_PASSPHRASE |

NB: for JWT i already pushed my files with the correct configuration for testing but you can delete the files and create your own by the following commands:

```
set -e
apt-get install openssl
apt-get install acl
php bin/console lexik:jwt:generate-keypair
setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
```

By default the acl is installed but in case you incountered an error the installation of acl is necessary

```
apt-get install acl
```
