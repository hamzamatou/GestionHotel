<?php

namespace App\Factory;

use App\Entity\Reservation;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Reservation>
 */
final class ReservationFactory extends PersistentProxyObjectFactory
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
        return Reservation::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'chambre' => ChambreFactory::randomCreate(),
            'client' => ClientFactory::randomCreate(),
            'jourArr' => self::faker()->dateTime(),
            'jourDep' => self::faker()->dateTime(),
            'nbjours' => self::faker()->randomNumber(),
            'num' => self::faker()->randomNumber(),
            'resevEtat' => self::faker()->text(20),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Reservation $reservation): void {})
        ;
    }
}
