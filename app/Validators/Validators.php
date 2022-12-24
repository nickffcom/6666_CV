<?php

namespace App\Validators;

use Exception;
use Illuminate\Support\Facades\DB;

class ValidateIdForeign
{
    private $table = 0;
    private $column = 1;
    private $value = 2;
    /**
     * check id foreign by table ($parameters)
     *
     * @param [type] $attribute
     * @param [type] $value
     * @param [type] $parameters
     * @param [type] $validator
     * @return void
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        try {
            if (!isset($parameters[$this->table]) || !$value) {
                return false;
            }
            $data = DB::table($parameters[$this->table])->where(function ($q) use ($parameters) {
                if (!empty($parameters[$this->column]) && !empty($parameters[$this->value])) {
                    $q->where($parameters[$this->column], $parameters[$this->value]);
                }
            })->find($value);
            if ($data && empty($data->deleted_at)) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * check quantity ($parameters)
     *
     * @param [type] $attribute
     * @param [type] $value
     * @param [type] $parameters
     * @param [type] $validator
     * @return void
     */
    public function validateQuantity($attribute, $value, $parameters, $validator){
        try {
            if (!isset($parameters[$this->table]) || !isset($parameters[$this->column]) || !isset($parameters[$this->value])){
                return false;
            }
            $data = DB::table($parameters[$this->table])->where('id', $value[$parameters[$this->value]])->value($parameters[$this->column]);
            if (empty($value['quantity'] % $data)){
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }
}