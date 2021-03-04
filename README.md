2-fa-demo
========================

The "2-fa-demo" project is a reference application created to show how
to implement 2-Factor Authentication on Symfony applications using [Authy by Twilio][1].

Requirements
------------

  * PHP 7.4 or higher
  * PDO-SQLite PHP extension enabled;
  * [Git][2]
  * [Composer][3]
  * [Symfony CLI][4]
  * and the [usual Symfony application requirements][5].


Installation
------------

[Download Symfony][4] to install the `symfony` binary on your computer and run
this command:

```bash
$ git clone https://github.com/ybjozee/2-fa-demo 2-fa-demo
$ cd 2-fa-demo
$ composer install
```


Usage
-----

Make a local version of the `.env` file 

```bash
$ cp .env .env.local
```

Update the `DATABASE_URL` and `AUTHY_API_KEY` accordingly

``` ini
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
AUTHY_API_KEY="INSERT_YOUR_PRODUCTION_API_KEY_HERE"
```

Set up your database

```bash
$ ./bin/console doctrine:database:create
$ ./bin/console doctrine:schema:update --force
```
run this command and access the application in your
browser at the given URL (<https://localhost:8000> by default):

```bash
$ symfony serve
```

[1]: https://authy.com/blog/authy-vs-google-authenticator/
[2]: https://git-scm.com/
[3]: https://getcomposer.org/
[4]: https://symfony.com/download
[5]: https://symfony.com/doc/current/reference/requirements.html
[7]: https://github.com/symfony/webpack-encore
