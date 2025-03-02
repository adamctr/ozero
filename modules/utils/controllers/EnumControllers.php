<?php

class Enums
{


    public static function getStatusOptions(): array
    {
        return [
            'payé' => 'payé',
            'expédié' => 'expédié',
            'livré' => 'livré',
            'annulé' => 'annulé',
        ];
    }
}
