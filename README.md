# Signifly Sample Application

## Introduction

This is the Signifly Sample Application.

## Installation using Composer

To use git to clone this project:

```bash
$ git clone git@github.com:telkins/signifly-sample-app.git
```

Navigate to the project root.

You can use composer to install your dependencies (download composer first via http://www.getcomposer.org):

```bash
$ ./composer.phar install
```

Choose defaults whenever composer prompts you.

Make sure you have executed the database creation script.

Copy <code>config/autoload/local.php.dist</code> to <code>config/autoload/local.php</code>
and update the database connection data.

You can now test it out using PHP's built-in web server:

```bash
$ php -S 0.0.0.0:8080 -t public/ public/index.php
```

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note:** The built-in CLI server is *for development only*.
