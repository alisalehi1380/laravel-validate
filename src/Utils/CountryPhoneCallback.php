<?php

namespace Milwad\LaravelValidate\Utils;

class CountryPhoneCallback
{
    /**
     * Create a new phone validator instance.
     *
     * @param  mixed  $value The phone number to validate.
     * @param  string  $code The country codes to validate against. String can be separated by comma
     * @param  string|null  $attribute
     */
    public function __construct(private mixed $value, private string $code, string|null $attribute = null) {}

    // TODO: Add a feature to add validate method for your own country!

    /**
     * Validate Nigeria phone number.
     *
     * @return false|int
     */
    protected function validateNE()
    {
        return preg_match('/^(\+227|00227|227)?\d{8}$/', $this->value);
    }

    /**
     * Validate Iran phone number.
     *
     * @return false|int
     */
    protected function validateIR()
    {
        return preg_match('/^(\+98|0)?9\d{9}$/', $this->value);
    }

    /**
     * Call the phone validator method for each country code and return the results.
     *
     * @return array An array of validation results, where each key is a country code and the value is either `true` or `false`.
     *
     * @throws \BadMethodCallException if the validator method for a country code does not exist.
     */
    public function callPhoneValidator(): array
    {
        $results = [];
        $codes = explode(',', $this->code);
        $codes = array_map('strtoupper', $codes);

        foreach ($codes as $code) {
            $methodName = 'validate'.$code;

            if (method_exists($this, $methodName)) {
                $results[$code] = $this->{$methodName}();
            } else {
                throw new \BadMethodCallException("Validator method '{$methodName}' does not exist.");
            }
        }

        return $results;
    }
}
