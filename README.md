## Init project

Install vendor: Move to project folder and execute command

`$ composer install`

## Check coding convention

Check coding convention via phpcs package: execute command

`$ ./vendor/bin/phpcs --standard=PSR12 api/ --colors`

## Start server

`$ php -S localhost:8000`

## Create test user

`POST http://localhost:8000/api/register.php`

## Login user

`POST http://localhost:8000/api/login.php`

```
{
	"email": "xuanbt@gmail.com",
	"password": "12345678"
}
```

Response

```
{
    "message": "Success",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMCIsImF1ZCI6IlRIRV9BVURJRU5DRSIsImlhdCI6MTU4NjgzNjE1OSwibmJmIjoxNTg2ODM2MTY5LCJleHAiOjE1ODY4MzYyMTksImRhdGEiOnsiaWQiOiIxIiwibmFtZSI6Ilh1YW5CVCIsImVtYWlsIjoieHVhbmJ0QGdtYWlsLmNvbSJ9fQ.I97mrVHdCj-_OGvKQ5mKYzQA3wAwPJQTzebBq0hGt00",
    "email": "xuanbt@gmail.com",
    "name": "XuanBT",
    "expireAt": 1586836219
}
```

## Change user information

`POST http://localhost:8000/api/update-account.php`

```
{
	"access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMCIsImlhdCI6MTU4Njg0MDA4NSwibmJmIjoxNTg2ODQwMDk1LCJleHAiOjE1ODc0NDQ4ODUsImRhdGEiOnsiaWQiOiIxIiwiZW1haWwiOiJ4dWFuYnRAZ21haWwuY29tIn19.nOu9M3cOHVZix3imK6VKtfXTFSOu44wCaVzg2mgSvew",
	"name": "New name",
	"phone": "0123456789",
	"address": "address"
}
```

Response

```
{
    "message": "Success"
}
```
