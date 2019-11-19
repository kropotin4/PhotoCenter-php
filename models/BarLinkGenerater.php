<?php

require_once "tables/UserType.php";

class BarLinkGenerater
{

    public static function gen($access_rights){
        $res = "<li><a href=\"?\" ><span class=\"glyphicon glyphicon-home\"></span> Главная</a></li>";
        if (!isset($access_rights))
            return $res;

        $part1 = 0;
        if ($access_rights->consultants_t > 1){
            if ($part1 == 0) {
                $res .= "<hr>";
                $part1 = 1;
            }
            $res .= "<li><a href=\"?table=consultants\" >Consultants</a></li>";
        }
        if($access_rights->customers_t > 1){
            if ($part1 == 0) {
                $res .= "<hr>";
                $part1 = 1;
            }
            $res .= "<li><a href=\"?table=customers\" >Customers</a></li>";
        }
        if($access_rights->products_t > 1){
            if ($part1 == 0) {
                $res .= "<hr>";
                $part1 = 1;
            }
            $res .= "<li><a href=\"?table=products\" >Products</a></li>";
        }
        if($access_rights->photo_centers_t > 1){
            if ($part1 == 0) {
                $res .= "<hr>";
                $part1 = 1;
            }
            $res .= "<li><a href=\"?table=photo_centers\" >Photo Centers</a></li>";
        }
        if($access_rights->product_types_t > 1){
            if ($part1 == 0) {
                $res .= "<hr>";
                $part1 = 1;
            }
            $res .= "<li><a href=\"?table=product_types\" >Product types</a></li>";
        }
        if($access_rights->service_t > 1){
            if ($part1 == 0) {
                $res .= "<hr>";
                $part1 = 1;
            }
            $res .= "<li><a href=\"?table=services\" >Service</a></li>";
        }

        if($access_rights->users_t > 1){
            if ($part1 != 2) {
                $res .= "<hr>";
                $part1 = 2;
            }
            $res .= "<li><a href=\"?table=users\" >Users</a></li>";
        }
        if($access_rights->user_types_t > 1){
            if ($part1 != 2) {
                $res .= "<hr>";
                $part1 = 2;
            }
            $res .= "<li><a href=\"?table=user_types\" >User Types</a></li>";
        }

        return $res;
    }
    
}