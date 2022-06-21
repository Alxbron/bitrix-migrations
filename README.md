[![Latest Stable Version](https://poser.pugx.org/arrilot/bitrix-migrations/v/stable.svg)](https://packagist.org/packages/arrilot/bitrix-migrations/)
[![Total Downloads](https://img.shields.io/packagist/dt/arrilot/bitrix-migrations.svg?style=flat)](https://packagist.org/packages/Arrilot/bitrix-migrations)
[![Build Status](https://img.shields.io/travis/arrilot/bitrix-migrations/master.svg?style=flat)](https://travis-ci.org/arrilot/bitrix-migrations)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/arrilot/bitrix-migrations/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/arrilot/bitrix-migrations/)

# Bitrix-migrations

*Database migrations for Bitrix and more*

## Installation

1) `composer config repositories.arrilot/bitrix-migrations vcs https://github.com/informunity/bitrix-migrations.git`

2) `composer require arrilot/bitrix-migrations`

3) `cp vendor/arrilot/bitrix-migrations/migrator migrator` - copy the executable file to a convenient location.

4) Open the `migrator` file and make sure the correct $_SERVER['DOCUMENT_ROOT'] is set. Change the settings if necessary.

5) `php migrator install`

This command will create a `migrations` table in the database to store the names of completed migrations.

Default:

1) The table is called `migrations`.

2) `composer.json` and `migrator` are in the root of the site.

3) Migration files will be created in the `.migrations` directory relative to the file copied in step 3.

If necessary, all this can be changed in the copied `migrator` file.

*It is highly recommended to make `migrator` and `.migrations` unavailable via http through the web server.*
