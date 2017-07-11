Hotel Deals Project
=========================
A simple Php app that is built using the Yii framework,
using  JSON API (https://offersvc.expedia.com/offers/v2/getOffers?scenario=deal-finder&page=foo&uid=foo&productType=Hotel) that presents a bunch of Hotel deals as lists.


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      config/             contains application configurations
      constant/           contains statical Array can be moved to db in futures
      controllers/        contains Web controller classes
      lib/                contains libarary classes
      models/             contains model classes
      runtime/            contains files generated during runtime
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0. (of course we need apache server)


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
php composer.phar global require "fxp/composer-asset-plugin:^1.3.1"
php composer.phar create-project --prefer-dist --stability=dev yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL

~~~
http://localhost/expedia/web/index
~~~


Make sure you run composer install Update dependencies
```
    composer update
```

Demo app
--------
```
    http://hotel-offer-app.herokuapp.com/
```

Notes:
------
1. I played with image resolution trying to fit image on list but some image was broken and give me 404 (but some image goes to 404).There is multi image size which end with ’t.jpg/l.jpg/z.jpg/b.jpg’.
2. I was unable to find min/max total rate boundaries
3. I try to use Autcomplet for country and I assume they accept alpa3code
4. design is very basics because I am Backend-developber but this link(https://devhub.io/repos/randmuhtaseb-hotels-deals-app) help me a lot
