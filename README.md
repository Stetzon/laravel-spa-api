<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Purpose

I have created this repo as a baseline working example of a Laravel application set up to be used as a backend API for a single page application.  Laravel Sanctum and Fortify have made this process much simpler; however, there are still some common setup and configuration difficulties that I have personally run into, and that I see everywhere on Stack Overflow and Laracasts.  Too many hours have been wasted troubleshooting CORS or 419 token mismatch errors, so hopefully this example allows people to get up and running without all the headache.

## Changes from default Laravel installation

- Includes [Sanctum](https://laravel.com/docs/8.x/sanctum#how-it-works-spa-authentication) for session-based API Authentication for your SPA
- Includes [Fortify](https://laravel.com/docs/8.x/fortify) to generate the default Auth Controllers and fucntionality
- Includes [Sail](https://laravel.com/docs/8.x/sail) to quickly get up and running on any OS
- Strip out included frontend functionality (mix, package.json, blade, js, css, etc)
- Updated session, cors, and sanctum configuration
    - Set default session driver to cookie
    - Set appropriate env variables
    - Add credential support to cors
- Add intial auth routes
- Add initial test user
- Update redirect from RedirectIfAuthenticated middleware - return JSON message
- Add fix for VerifyCsrfToken middleware to work with REST clients.  This appears to be because of the base64 encoded value for the XSRF-TOKEN cookie sometimes having rouge characters appended to the end.  It seems like when sending requests from the browser the application can handle appropriately, but when sending from a REST client like Insomnia or Postman, this would cause token mismatches or DecryptExceptions.  The fix is to read in the value of the token, strip out the extra characters at the end, then continue processing.  If anyone has better insight in to how to fix this, please do open an issue or PR!  More info here:
    - [Changes made](https://github.com/Stetzon/laravel-spa-api/commit/ca55c9a47c4bcac514ceab64f1175d511ef621f0#diff-f28a7db3bd34f0ceb7dcdc2c804fc234b1089986b6a3a813359a27048ee5b469R35-R42)
    - https://laracasts.com/discuss/channels/laravel/xsrf-decryptexception-the-payload-is-invalid
    - https://stackoverflow.com/questions/44652194/laravel-decryptexception-the-payload-is-invalid
- Include sample export configuration for an Insomnia Request Collection to quickly be able to test out the provided API endpoints. 
- Include sample authentication feature tests

## Installation

1. Clone the repo
```
$ git clone git@github.com:Stetzon/laravel-spa-api.git
$ cd laravel-spa-api
```
2. Install dependencies
```
composer install
```
3. Run the application
```
$ vendor/bin/sail up
```
4. Test away


## License

[MIT license](https://opensource.org/licenses/MIT).
