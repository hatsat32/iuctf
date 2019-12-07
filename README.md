# IUCTF

A ctf platform for everyone.

## Why We did this ?

Because

* We wanted to do something about cyber security.
* We wanted something with codeigniter 4 (Because codeigniter 4 awesome)
* Just for fun :)

If you like our project, please ...

* Create pull request.
* Share with your friends.

If you don't like or hate

* Feel free not to use it.
* Or show us how to do it better.

## Installation

First steps:

```
$ git clone https://gitlab.com/iucyber/iuctf-prototype.git
$ cd iuctf-prototype
$ composer install
```

You must install these php extensions. These extensions need for codeigniter 4.

```
php-curl
php-intl
php7.3-mbstring
php-xml
```

Run migrations and create `admin` group.

```
$ php spark migrate

$ php spark auth:create_group admin
```

Go and regirter. After then make your use as admin.

```
$ php spark iuctf:makeadmin
```

and enjoy!

```
$ php spark serve
```

## LICENSE

This Project under MIT license.