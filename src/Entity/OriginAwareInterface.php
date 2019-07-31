<?php

declare(strict_types=1);

namespace Ecolos\SyliusOriginPlugin\Entity;

interface OriginAwareInterface
{
    public function addOriginCountry(?string $originCountryCode): void;

    public function getOriginCountryCode(): ?string;

    public function getOriginCountryName();

    public function removeOriginCountry(): void;

    public function setOriginCountry(?string $originCountryCode): void;
}
