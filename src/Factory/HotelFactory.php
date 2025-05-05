<?php

namespace App\Factory;

use App\Entity\Hotel;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Hotel>
 */
final class HotelFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Hotel::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'adresse' => self::faker()->text(255),
            'email' => self::faker()->text(255),
            'nbchambres' => self::faker()->randomNumber(),
            'nom' => self::faker()->text(255),
            'tel' => self::faker()->randomNumber(),
            
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Hotel $hotel): void {})
        ;
    }
}
