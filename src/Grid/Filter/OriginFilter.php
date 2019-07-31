<?php

declare(strict_types=1);

namespace Ecolos\SyliusOriginPlugin\Grid\Filter;

use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class OriginFilter implements FilterInterface
{
    private $originRepository;

    public function __construct(RepositoryInterface $originRepository)
    {
        $this->originRepository = $originRepository;
    }

    public function apply(DataSourceInterface $dataSource, $name, $data, array $options = []): void
    {
        if (isset($data['origins'])) {
            if (!is_array($data['origins'])) {
                $data['origins'] = [$data['origins']];
            }

            $origins = [];
            foreach ($data['origins'] as $origin) {
                $origins[] = $origin;
            }

            $dataSource->restrict(
                $dataSource->
                getExpressionBuilder()
                    ->in("originCountryCode", $origins)
            );
        }
    }
}
