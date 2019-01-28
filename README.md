# Laravel Localize
[![Packagist](https://img.shields.io/packagist/v/koenhoeijmakers/laravel-localize.svg?colorB=brightgreen)](https://packagist.org/packages/koenhoeijmakers/laravel-localize)
[![Build Status](https://scrutinizer-ci.com/g/koenhoeijmakers/laravel-localize/badges/build.png?b=master)](https://scrutinizer-ci.com/g/koenhoeijmakers/laravel-localize/build-status/master) 
[![Code Coverage](https://scrutinizer-ci.com/g/koenhoeijmakers/laravel-localize/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/koenhoeijmakers/laravel-localize/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/koenhoeijmakers/laravel-localize/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/koenhoeijmakers/laravel-localize/?branch=master)
[![license](https://img.shields.io/github/license/koenhoeijmakers/laravel-localize.svg?colorB=brightgreen)](https://github.com/koenhoeijmakers/laravel-localize)
[![Packagist](https://img.shields.io/packagist/dt/koenhoeijmakers/laravel-localize.svg?colorB=brightgreen)](https://packagist.org/packages/koenhoeijmakers/laravel-localize)

An as minimalistic as possible localization package that works via `/en/` `/nl/` routing.

## Installation
Require the package.
```sh
composer require koenhoeijmakers/laravel-localize
```

... and optionally publish the config.
```sh
php artisan vendor:publish --provider="KoenHoeijmakers\LaravelLocalize\LocalizeServiceProvider"
```
