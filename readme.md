## TelegramTester

```shell
echo "username" \
  && read username \
  && echo "token" \
  && read token \
  && git clone "https://${username}:${token}@github.com/managanemeke/MadelineProto.git" MadelineProto
```

```shell
docker compose run --rm composer install
```

```shell
cd MadelineProto && composer install
```

```shell
docker compose run --rm php vendor/bin/phpunit
```
