<?php

class DateHelper
{
    /**
     * Formate une date au format "Le d/m/Y à H:i"
     * 
     * @param string $date La date à formater au format 'Y-m-d H:i:s'
     * @return string La date formatée
     */
    public static function formatDate($date)
    {
        $dateTime = new DateTime($date);
        return "Le " . $dateTime->format('d/m/Y \à H:i');
    }
}
