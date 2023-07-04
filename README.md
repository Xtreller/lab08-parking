
## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## How to run this project
    1. git clone https://github.com/Xtreller/lab08-parking.git |
    2. composer install
    3. php artisan migrate
    4. php artisan db:seed
## ENDPOINTS

> **_NOTE:_** All endpoints have prefix "/api/lab08/" and returns json object;

EXAMPLE: http://127.0.0.1:8000/api/lab08/free_spaces


| Method  | Route | Route info | Body |
| ------------- | ------------- | ------------- | :-------------: |
| GET  | /cars  |  returns list of cars  ||
| GET  | /free_spaces  |   returns available spaces at the moment; ||
| POST | /register_car  |   registers_car |  {"registration":"R1644KM", "type":1,/*[1 to 3 or add other car_types]*/"discount_card":1,/*[1 to 3 or add other discount_cards]*/}|
| GET  | /car_enters/{registration}  | adds car to parking | |
| GET  | /car_exits/{registration}  | removes car from parking | |
| GET  | /get_amount/{registration}  | get spent amount and time for car | |


## Versions
- PHP - 8.2.4
- Laravel - ^9

