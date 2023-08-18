# PHP-Login-With-Google
Login with Google account via PHP &amp; Mysqli

## Usage
If you don't have `Google API Client`, just go here to generate yours:
https://console.cloud.google.com/apis/

Then enter the `Client_ID` &amp; `Client_Secret` [here](./config.php#L3-L5), and also set your `Callback_URL`:
```php
define('GOOGLE_CLIENT_ID', 'Insert_Google_Client_ID');  
define('GOOGLE_CLIENT_SECRET', 'Insert_Google_Client_Secret'); 
define('GOOGLE_REDIRECT_URL', 'Callback_URL'); 
```
