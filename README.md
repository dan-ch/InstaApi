# InstakilogramApi

## Description

InstakilogramApi is a Laravel backend application(API)/part of Instakilogram app which is a photo sharing application, just like the well-known Instagram, that contains core functionalities of this type of software(more in section below). The API takes care of the consistency and validation of the data coming in and sent to the frontend application that is built with React.js. Frontend app you can find on my GitHub at this link: <https://github.com/dan-ch/InstakilogramUi>

While working on this project, I learned primarily:

- how to secure and connect the Laravel API with the front-end application using Sanctum and Socialite
- how to create local file sotrage and connect API to Cloudinary file storage
- how to use Algolia to search for users and posts

## Features

- CRUD operation on posts
- Adding and deleting post comments
- Like system
- Searching for users and posts using Algolia
- Following other users
- "Wall" based on followed users posts
- Posts pagination on "wall" and user profile
- User registration
- Sign in with Google and Github using Socialite
- Authentication using Sanctum token
- Custom password validation
- Integration with Cloudinary platform to store posts images

## Built with

- [Laravel](https://laravel.com/) ^8.65
- [Algolia scout-extended](https://www.algolia.com/doc/framework-integration/laravel/getting-started/introduction-to-scout-extended/?client=php) ^1.20
- [Cloudinary-php](https://cloudinary.com/documentation/php_integration) ^2
- [Sanctum](https://laravel.com/docs/8.x/sanctum) ^2.12
- [Socialite](https://laravel.com/docs/8.x/socialite) ^5.2

Dev dependencies:

- [Telescope](https://laravel.com/docs/8.x/telescope) ^4.7
- [Faker](https://laravel.com/docs/7.x/database-testing) ^1.9.1

## Getting started

API is deployed on Heroku at this link: <https://instakilogram-api.herokuapp.com/>

You can try the Instakilogram using fronted application at this link: <https://dan-ch.github.io/InstakilogramUi/>

### Prerequisites

- php 8.1
- [Composer](https://getcomposer.org/) 2.2.6
- account on [Cloudinary](https://cloudinary.com/) platform
- account on [Algolia](https://www.algolia.com/) platform

### Installation

1. Clone repository

    ```txt
    git clone https://github.com/dan-ch/InstaApi
    ```

2. Install requierd packages using Composer:

    ```txt
    composer install
    ```

3. In main folder create `.env` file and provide valid enviroment variables like so:

    ```env
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=your_app_key
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug
    
    # for ex. sqlite
    DB_CONNECTION=sqlite

    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DRIVER=public
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120

    GITHUB_CLIENT_ID=your_github_client_id
    GITHUB_CLIENT_SECRET=your_github_client_secret
    GITHUB_REDIRECT_URI=http://127.0.0.1:8000/api/login/gihtub/callback

    GOOGLE_CLIENT_ID=your_google_client_id
    GOOGLE_CLIENT_SECRET=your_google_client_secret
    GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/api/login/google/callback

    ALGOLIA_APP_ID=your_algolia_app_id
    ALGOLIA_SECRET=your_algolia_secret

    CLOUDINARY_URL=your_cloudinary_url
    ```

4. If you are using sqlite database in `/database` folder create `database.sqlite` file.

5. Run the migrations:

    ```txt
    php artisan migrate
    ```

## Usage

To run the application simply paste and run the following command in your CLI

```txt
php artisan serve
```

## License

Distributed under the MIT License. See `LICENSE.txt`.
