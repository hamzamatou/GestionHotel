<?php

// src/Enum/ReservationEtat.php
namespace App\Enum;

enum ReservationEtat: string
{
    case CONFIRME = 'confirmé';
    case ANNULE = 'annulé';
    
    /**
     * Retourne le libellé lisible de l'état
     */
    public function label(): string
    {
        return match($this) {
            self::CONFIRME => 'Réservation confirmée',
            self::ANNULE => 'Réservation annulée',
        };
    }
    
    /**
     * Retourne les choix formatés pour les formulaires
     * @return array<string, string>
     */
    public static function choices(): array
    {
        return [
            self::CONFIRME->label() => self::CONFIRME->value,
            self::ANNULE->label() => self::ANNULE->value,
        ];
    }
    
    /**
     * Vérifie si une valeur existe dans l'énumération
     */
    public static function exists(string $value): bool
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return true;
            }
        }
        return false;
    }
}