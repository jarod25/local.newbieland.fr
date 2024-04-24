<?php

namespace App\Entity;

enum MedalsEnum : string
{
    case GOLD = 'GOLD';
    case SILVER = 'SILVER';
    case BRONZE = 'BRONZE';
    case DEFAULT = 'NO_MEDAL';

    public function getLabel(): string
    {
        return match ($this) {
            self::GOLD => 'Médaille d\'or',
            self::SILVER => 'Médaille d\'argent',
            self::BRONZE => 'Médaille de bronze',
            self::DEFAULT => 'Pas de médailles',
        };
    }
}

