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
mkdir telegram-session
```

```shell
cp .env.example .env
```

```shell
docker compose run --rm php vendor/bin/phpunit
```
