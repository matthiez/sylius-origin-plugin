<h1 align="center">Sylius Origin Plugin</h1>

<p align="center">Adds a "origin" field to your product entity and a filter to the frontend.</p>

## Installation
1. Add the "repositories" key to to composer.json
```json
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ecolos-de/sylius-origin-plugin.git"
        }
    ],
```

2. Install package from Github via terminal
```shell script
composer require ecolos/sylius-origin-plugin
```

3. add to config/bundles.php
```php
    Ecolos\SyliusOriginPlugin\EcolosSyliusOriginPlugin::class => ['all' => true],
```

4. Add to config/packages/_sylius.yml
```twig
    - { resource: "@EcolosSyliusOriginPlugin/Resources/config/_sylius.yml" }
```

5. Add to config/services.yml
```twig
    - { resource: "@EcolosSyliusOriginPlugin/Resources/config/services.yml" }
```

6. Add to src/Entity/Product.php
```php
use Ecolos\SyliusOriginPlugin\Entity\OriginTrait;
class Product extends BaseProduct implements ProductInterface
{ 
    use EuTrait, MakerTrait, OriginTrait, SeoTrait;
}
```

7. Update doctrine changes
```shell script
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:execute --up XXXXXXXXXXX
```

<h2>ToDo</h2>

<ul>
<li>Write tests</li>
</ul>
