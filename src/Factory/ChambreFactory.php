<?php

namespace App\Factory;

use App\Entity\Chambre;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Chambre>
 */
final class ChambreFactory extends PersistentProxyObjectFactory
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
        return Chambre::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'etage' => self::faker()->randomNumber(),
            'etat' => self::faker()->text(20),
            'hotel' => HotelFactory::randomCreate(),
            'nbLits' => self::faker()->randomNumber(),
            'numC' => self::faker()->randomNumber(),
            'prix' => self::faker()->randomFloat(),
            'style' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Chambre $chambre): void {})
        ;
    }
}
