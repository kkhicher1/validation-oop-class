<?php
class Validator
{
    public $data;
    private $errors = [];
    public function __construct($data = array(), $rules = array())
    {
        $this->data = $data;
        foreach ($rules as $field_key => $field_value) {
            $rule_array = explode('|', $field_value);
            foreach ($rule_array as $rule) {
                if (preg_match('/(.*):(.*)\w+/', $rule)) {
                    $colon_rule = explode(":", $rule);
                    $rule_name = $colon_rule[0];
                    $this->$rule_name($field_key, $colon_rule[1]);
                } else {
                    $this->$rule($field_key);
                }
            }
        }
    }
    //checking required rule
    public function required($field_key)
    {
        if (empty($this->data[$field_key])) {
            $this->errors[$field_key][] = "{$field_key} is required";
        }
    }
    //checking string rule
    public function string($field_key)
    {
        if (is_numeric($this->data[$field_key]) == true) {
            $this->errors[$field_key][] = "{$field_key} Should be a String";
        }
    }
    //checing numeric rule
    public function int($field_key)
    {
        if (is_numeric($this->data[$field_key]) == false) {
            $this->errors[$field_key][] = "{$field_key} Should be a number";
        }
    }
    //cheking max rule
    public function max($field_key, $max_length)
    {
        if (isset($this->data[$field_key])) {
            if (strlen($this->data[$field_key]) > $max_length) {
                $this->errors[$field_key][] = "{$field_key} Should be less than $max_length";
            }
        }
    }
    //checking min rule
    public function min($field_key, $min_length)
    {
        if (isset($this->data[$field_key])) {
            if (strlen($this->data[$field_key]) < $min_length) {
                $this->errors[$field_key][] = "{$field_key} Should be greator than $min_length";
            }
        }
    }





    //pass if there are not errors found
    public function pass()
    {
        if (count($this->errors) == 0) {
            return true;
        } else {
            return false;
        }
    }
    // return errors if any found
    public function getErrors()
    {
        $errors_data = [];
        if (count($this->errors) > 0) {
            foreach ($this->errors as $errors) {
                foreach ($errors as $error) {
                    $errors_data[] = $error;
                }
            }
        }
        return $errors_data;
    }
}
