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
    public $id_field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table,$id_field)
    {
        $this->table = $table;
        $this->id_field = $id_field;
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
        $data = DB::table($this->table)->select($this->id_field)->where($attribute, $value)->first();
        if(empty($data)){
            return FALSE;
        }
        Session::flash($this->id_field, $data->id);
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
