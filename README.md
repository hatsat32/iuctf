# iuctf prototype

prototype for iuctf ctf platform

## Kurulum

İlk adımlar.

```
# clone the repo

$ cd iuctf-prototype
$ composer install
```

Şu php eklentilerini kur. Codeigniterin Çalışması için gerekli.

```
php-curl
php-intl
php7.3-mbstring
php-xml
```

Migrations uygula ve admin grubu oluştur

```
$ php spark migrate

$ php spark auth:create_group admin
```

Siteye git ve kaydol. Ardından o kullanıcıyı admin yap.

```
$ php spark iuctf:makeadmin
```

Ve tadını çıkar :)

```
$ php spark serve
```