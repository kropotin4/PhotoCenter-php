<?php

class UserType {
    public $user_type_id;
    public $consultants_t;
    public $customers_t;
    public $photo_centers_t;
    public $products_t;
    public $product_types_t;
    public $service_t;
    public $users_t;
    public $user_types_t;

    public function __toString()
    {
        $str = '|';
        if ($this->consultants_t != 0){
            $str .= 'consultants_t|';
        }
        if ($this->customers_t != 0){
            $str .= 'customers_t|';
        }
        if ($this->photo_centers_t != 0){
            $str .= 'photo_centers_t|';
        }
        if ($this->products_t != 0){
            $str .= 'products_t|';
        }
        if ($this->product_types_t != 0){
            $str .= 'product_types_t|';
        }
        if ($this->service_t != 0){
            $str .= 'service_t|';
        }
        if ($this->users_t != 0){
            $str .= 'users_t|';
        }
        if ($this->user_types_t != 0){
            $str .= 'user_types_t|';
        }
        return $str;
    }
}
