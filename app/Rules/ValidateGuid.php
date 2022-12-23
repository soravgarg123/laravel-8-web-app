<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ValidateGuid implements Rule
{
    /**
     * Summary of table
     * @param string $table
     * @param integer $id
    */
    public $table;
    public $primary_key;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table,$primary_key)
    {
        $this->table = $table;
        $this->primary_key = $primary_key;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /* Validate GUID */
        $data = DB::table($this->table)->select($this->primary_key)->where($attribute, $value)->first();
        if(empty($data)){
            return FALSE;
        }
        Session::flash($this->primary_key, $data->{$this->primary_key});
        return TRUE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid :attribute';
    }
}
