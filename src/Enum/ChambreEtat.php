<?php

namespace App\Enum;

enum ChambreEtat: string
{
    case LIBRE = 'libre';
    case OCCUPEE = 'occupée';
    case RESERVEE = 'réservée';  // Correction orthographique
    case MAINTENANCE = 'maintenance';  // Ajout plus explicite que 'autre'
    case NETTOYAGE = 'nettoyage';  // Ajout d'un état utile

    /**
     * Retourne le libellé lisible de l'état
     */
    public function label(): string
    {
        return match($this) {
            self::LIBRE => 'Libre',
            self::OCCUPEE => 'Occupée',
            self::RESERVEE => 'Réservée',
            self::MAINTENANCE => 'En maintenance',
            self::NETTOYAGE => 'En nettoyage',
        };
    }

    /**
     * Retourne les choix formatés pour les formulaires
     * @return array<string, string>
     */
    public static function choices(): array
    {
        return [
            'Libre' => self::LIBRE->value,
            'Occupée' => self::OCCUPEE->value,
            'Réservée' => self::RESERVEE->value,
            'En maintenance' => self::MAINTENANCE->value,
            'En nettoyage' => self::NETTOYAGE->value,
        ];
    }

    /**
     * Vérifie si une valeur existe dans l'énumération
     */
    public static function exists(string $value): bool
    {
        return !empty(self::tryFrom($value));
    }
}