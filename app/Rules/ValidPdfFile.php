<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPdfFile implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if (!$value || !$value->isValid()) {
            return false;
        }

        // Check MIME type
        if ($value->getMimeType() !== 'application/pdf') {
            return false;
        }

        // Check file extension
        if (strtolower($value->getClientOriginalExtension()) !== 'pdf') {
            return false;
        }

        // Check PDF header
        try {
            $handle = fopen($value->getRealPath(), 'rb');
            $header = fread($handle, 4);
            fclose($handle);
            
            return $header === '%PDF';
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid PDF document.';
    }
} 