<?php //mise ne forme de la date au format fr
    function formatDate($date)
        {
            $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
            $formatter->setPattern('EEEE d MMMM yyyy');
            return $formatter->format($date);
        }
?>