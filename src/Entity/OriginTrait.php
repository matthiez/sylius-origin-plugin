<?php
declare(strict_types=1);

namespace Ecolos\SyliusOriginPlugin\Entity;

use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Intl\Intl;

trait OriginTrait
{
    /**
     * @Column(type="string", nullable=true)
     * @var string|null
     */
    public $originCountryCode;

    public function getOriginCountryName()
    {
        return Intl::getRegionBundle()->getCountryName($this->originCountryCode);
    }

    public function getOriginCountryCode(): ?string
    {
        return $this->originCountryCode;
    }

    public function addOriginCountry(?string $originCountryCode): void
    {
        $this->originCountryCode = $originCountryCode;
    }

    public function setOriginCountry(?string $originCountryCode): void
    {
        $this->originCountryCode = $originCountryCode;
    }

    public function removeOriginCountry(): void
    {
        $this->originCountryCode = null;
    }
}
