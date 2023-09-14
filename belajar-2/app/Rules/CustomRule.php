<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;

class CustomRule implements DataAwareRule, ValidationRule, ValidatorAwareRule
{
    /*
        Using Rule Objects

        Laravel provides a variety of helpful validation rules; however, you may wish to specify some of your own. One method of
        registering custom validation rules is using rule objects. To generate a new rule object, you may use the make:rule Artisan
        command. Let's use this command to generate a rule that verifies a string is uppercase. Laravel will place the new rule in
        the app/Rules directory. If this directory does not exist, Laravel will create it when you execute the Artisan command to
        create your rule
        -> php artisan make:rule Uppercase

        Once the rule has been created, we are ready to define its behavior. A rule object contains a single method: validate.
        This method receives the attribute name, its value, and a callback that should be invoked on failure with the validation
        error message

        Once the rule has been defined, you may attach it to a validator by passing an instance of the rule object with your
        other validation rules
    */
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Cek Apakah Setiap Kata Diawali Huruf Kapital
        if (is_string($value) && !is_numeric($value)) {
            $words = explode(' ', $value);

            foreach ($words as $word) {
                if (ctype_lower($word[0])) {
                    $fail('Every word in :attribute field must start with uppercase');
                }
            }
        } else {
            $fail('The :attribute field must be a string');
        }
    }

    /*
        Accessing Additional Data

        If your custom validation rule class needs to access all of the other data undergoing validation, your rule class may implement
        the Illuminate\Contracts\Validation\DataAwareRule interface. This interface requires your class to define a setData method.
        This method will automatically be invoked by Laravel (before validation proceeds) with all of the data under validation
    */
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static {
        $this->data = $data;

        return $this;
    }

    /*
        Or, if your validation rule requires access to the validator instance performing the validation, you may implement the
        ValidatorAwareRule interface
    */
    /**
     * The validator instance.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Set the current validator.
     */
    public function setValidator(\Illuminate\Validation\Validator $validator): static {
        $this->validator = $validator;

        return $this;
    }
}
