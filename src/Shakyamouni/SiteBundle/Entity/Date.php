<?php
namespace Shakyamouni\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Date
 *
 * @ORM\Table(name="date")
 */
class Date {

    var $days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    var $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

    function getAll($year)
    {
        $r = array();

        $date = new \DateTime($year . '-01-01');
        while ($date->format('Y') <= $year) {
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));
            $r[$y][$m][$d] = $w;
            $date->add(new \DateInterval('P1D'));
        }
        return $r;
    }
    
    function getMonthCalendar($year, $month)
    {
        $r = array();

        $date = new \DateTime($year . '-'. $month .'-01');
        
        while ($date->format('Y') <= $year && $date->format('n') == $month) {
            $y = $date->format('Y');
            $m = $month;
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));
            $r[$y][$m][$d] = $w;
            $date->add(new \DateInterval('P1D'));
        }
        return $r;
    }

}