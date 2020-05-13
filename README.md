# Demo sheet and chat using laravel-websocket

# Installation

1. Clone this repository
2. `composer install`
3. `cp .env.example .env`
4. `php artisan migrate`
5. `php artisan key:generate`
6. Fill PUSHER credential on `.env` file
7. Run `npm install` and `npm run dev`
8. `php artisan websockets:serve`
9. Register two users and create sheet for user 1
10. Open two browser and open same sheet
11. Show time

![Demo](https://github.com/choirool/sheet-and-chat/blob/master/demo.gif)
