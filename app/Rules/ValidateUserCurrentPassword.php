<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ValidateUserCurrentPassword implements Rule
{
    /**
     * Summary of table
     * @param integer $user_id
    */
    public $user_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
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
        /* Validate Current Password */
        $data = DB::table('users')->select('password')->where('id', $this->user_id)->first();
        if(empty($data) || !Hash::check($value, $data->password)){
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid current password.';
    }
}
