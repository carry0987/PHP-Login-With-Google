# PHP-Login-With-Google
Login with Google account via PHP &amp; Mysqli

![Login-With-Google-By-carry0987](./image/sign-in-with-google.svg)

## Usage
If you don't have `Google API Client`, just go here to generate yours:
https://console.developers.google.com/

Then enter the `Client_ID` &amp; `Client_Secret` [here](https://github.com/carry0987/PHP-Login-With-Google/blob/master/google_config.php#L10-L12), and also set your `Callback_URL`:
```php
define('GOOGLE_CLIENT_ID', 'Insert_Google_Client_ID');
define('GOOGLE_CLIENT_SECRET', 'Insert_Google_Client_Secret');
define('GOOGLE_REDIRECT_URL', 'Callback_URL');
