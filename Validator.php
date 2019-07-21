<?php
class Validator
{
    private $data;
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
    private function required($field_key)
    {
        if (empty($this->data[$field_key])) {
            $this->errors[$field_key][] = "{$field_key} is required";
        }
    }
    //checking string rule
    private function string($field_key)
    {
        if (is_numeric($this->data[$field_key]) == true) {
            $this->errors[$field_key][] = "{$field_key} Should be a String";
        }
    }
    //checing numeric rule
    private function int($field_key)
    {
        if (is_numeric($this->data[$field_key]) == false) {
            $this->errors[$field_key][] = "{$field_key} Should be a number";
        }
    }
    //cheking max rule
    private function max($field_key, $max_length)
    {
        if (isset($this->data[$field_key])) {
            if (strlen($this->data[$field_key]) > $max_length) {
                $this->errors[$field_key][] = "{$field_key} Should be less than $max_length";
            }
        }
    }
    //checking min rule
    private function min($field_key, $min_length)
    {
        if (isset($this->data[$field_key])) {
            if (strlen($this->data[$field_key]) < $min_length) {
                $this->errors[$field_key][] = "{$field_key} Should be greator than $min_length";
            }
        }
    }
    //checking digit length ...... digits:value
    private function digits($field_key, $length)
    {
        if (is_numeric($this->data[$field_key]) == true) {
            if (strlen($this->data[$field_key]) != $length) {
                $this->errors[$field_key][] = "{$field_key} Should be equal to $length";
            }
        } else {
            $this->errors[$field_key][] = "{$field_key} should be a number if you are using digits rule";
        }
    }
    // checking email.....
    private function email($field_key)
    {
        if (filter_var($this->data[$field_key], FILTER_VALIDATE_EMAIL) == false) {
            $this->errors[$field_key][] = "{$field_key} should be a email";
        }
    }
    //checking size .............. size:value
    private function size($field_key, $value)
    {
        if (is_numeric($this->data[$field_key]) == true) {
            if (strlen($this->data[$field_key]) != $value) {
                $this->errors[$field_key][] = "{$field_key} Should be equal to $value";
            }
        }
        if (is_string($this->data[$field_key]) == true) {
            if (strlen($this->data[$field_key]) != $value) {
                $this->errors[$field_key][] = "{$field_key} Should be equal to $value";
            }
        }
        if (is_array($this->data[$field_key]) == true) {
            if (count($this->data[$field_key]) != $value) {
                $this->errors[$field_key][] = "{$field_key} Should be equal to $value";
            }
        }
    }
    //checking ip ............. check both ipv4 and ipv6
    private function ip($field_key)
    {
        if (filter_var($this->data[$field_key], FILTER_VALIDATE_IP) == false) {
            $this->errors[$field_key][] = "{$field_key} Should be valid IP";
        }
    }
    //checking URL ............. e.g http://example.com or https://example.com
    private function url($field_key)
    {
        if (filter_var($this->data[$field_key], FILTER_VALIDATE_URL) == false) {
            $this->errors[$field_key][] = "{$field_key} Should be valid URL";
        }
    }
    //checking same field ............... same:value
    private function same($field_key, $same_field)
    {
        if ($this->data[$field_key] != $this->data[$same_field]) {
            $this->errors[$field_key][] = "{$field_key} & {$same_field} Should be Same";
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
