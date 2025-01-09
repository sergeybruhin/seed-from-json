# Laravel Seed From Json Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sergeybruhin/seed-from-json.svg?style=flat-square)](https://packagist.org/packages/sergeybruhin/seed-from-json)
[![Total Downloads](https://img.shields.io/packagist/dt/sergeybruhin/seed-from-json.svg?style=flat-square)](https://packagist.org/packages/sergeybruhin/seed-from-json)

Trait to help you seed data from json files.

## Installation

You can install the package via composer:

```bash
composer require sergeybruhin/seed-from-json
```

## Usage Example

```php

<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;
use SergeyBruhin\SeedFromJson\Traits\SeedFromJson;

class FeaturesSeeder extends Seeder
{
    use SeedFromJson;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
        * Default base directory database_path('data');
        * Default file name "data.json"
        * 'features' here is relative path to /database/data/features/data.json 
        */
        $this
            ->collectFromJson('features')
            ->each(function (array $entry) {
                $feature = Feature::where('name', $entry['name'])
                    ->first() ?? new Feature();

                $feature->name = $entry['name'];
                $feature->save();

                $this->logModel($feature);
            });
    }
}


```

### Testing (Not yet 💁‍♂️)

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email sundaycreative@gmail.com instead of using the issue tracker.

## Credits

- [Sergey Bruhin](https://github.com/sergeybruhin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
