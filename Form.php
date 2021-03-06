<?php
namespace P2Form;

class Form
{
    /**
     * Properties
     */
    private $request;
    public $hasErrors = false;

    /**
     * Form constructor
     */
    public function __construct(array $request)
    {
        # Store form data (POST or GET) in a class property called $request
        $this->request = $request;
    }

    /**
     * Returns true if *either* GET or POST have been submitted.
     */
    public function isSubmitted()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_GET);
    }

    /**
     * Get a value from the request, with the option of including a default
     * if the value is not set.
     */
    /**
     * Adding function which returns the uppercase first letter of form request
     */
    public function get(string $name, string $default = null)
    {
        return $this->request[$name] ?? $default;
    }

    public function getLetter(string $name, string $default = null)
    {
        $letter = $this->request[$name][0] ?? $default;
        return strtoupper($letter);
    }

    /**
     * Returns boolean as to whether a value is present in the request
     */
    public function has(string $name)
    {
        return isset($this->request[$name]);
    }

    /**
     * Given an array of fields => validation rules
     * Will loop through each field's rules
     * Returns an array of error messages
     * Stops after the first error for a given field
     * Available rules:
     * required, alpha, alphaNumeric, digit, numeric,
     * email, url, min:x, max:x, minLength:x, maxLength:x
     */
    public function validate(array $fieldsToValidate)
    {
        $errors = [];

        foreach ($fieldsToValidate as $fieldName => $rules) {
            # Each rule is separated by a |
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                # Get the value for this field from the request
                $value = $this->get($fieldName);

                # Handle any parameters with the rule, e.g. max:99
                $parameter = null;
                if (strstr($rule, ':')) {
                    list($rule, $parameter) = explode(':', $rule);
                }

                # Run the validation test with the given rule
                $test = $this->$rule($value, $parameter);

                # Test failed
                if (!$test) {
                    $method = $rule . 'Message';
                    $errors[] = 'The value for ' . $fieldName . ' ' . $this->$method($parameter);

                    # Only indicate one error per field
                    break;
                }
            }
        }

        # Set public property hasErrors as Boolean
        $this->hasErrors = !empty($errors);

        return $errors;
    }

    ### VALIDATION METHODS FOUND BELOW HERE ###

    /**
     * The value can not be blank
     */
    protected function required($value)
    {
        $value = trim($value);

        return $value != '' && isset($value) && !is_null($value);
    }

    protected function requiredMessage()
    {
        return 'can not be blank';
    }

    /**
     *  The value can only contain letters or spaces
     */
    protected function alpha($value)
    {
        return ctype_alpha(str_replace(' ', '', $value));
    }

    protected function alphaMessage()
    {
        return 'can only contain letters';
    }

    /**
     * The value can only contain alpha-numeric characters
     */
    protected function alphaNumeric($value)
    {
        return ctype_alnum(str_replace(' ', '', $value));
    }

    protected function alphaNumericMessage()
    {
        return 'can only contain letters or numbers';
    }

    /**
     * The value can only contain digits (0, 1, 2, 3, 4, 5, 6, 7, 8, 9)
     */
    protected function digit($value)
    {
        return ctype_digit(str_replace(' ', '', $value));
    }

    protected function digitMessage()
    {
        return 'can only contain digits';
    }

    /**
     * The value can only contain numbers
     */
    protected function numeric($value)
    {
        return is_numeric(str_replace(' ', '', $value));
    }

    protected function numericMessage()
    {
        return 'can only contain numerical values';
    }

    /**
     * The value must be a properly formatted email address
     */
    protected function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function emailMessage()
    {
        return 'must contain a correctly formatted email address';
    }

    /**
     * The value must be a properly formatted URL
     */
    protected function url($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    protected function urlMessage()
    {
        return 'must contain a correctly formatted URL';
    }

    /**
     * The character count of the value must be LESS THAN (non-inclusive) the given parameter
     * Fails if value is non-numeric
     */
    protected function minLength($value, $parameter)
    {
        return strlen($value) >= $parameter;
    }

    protected function minLengthMessage($parameter)
    {
        return 'must be at least ' . $parameter . ' character(s) long';
    }

    /**
     * The character count of the value must be LESS THAN (inclusive) the given parameter
     * Fails if value is non-numeric
     */
    protected function maxLength($value, $parameter)
    {
        return strlen($value) <= $parameter;
    }

    protected function maxLengthMessage($parameter)
    {
        return 'must be less than ' . $parameter . ' character(s) long';
    }

    /**
     * The value must be GREATER THAN (inclusive) the given parameter
     * Fails if value is non-numeric
     */
    protected function min($value, $parameter)
    {
        if (!$this->numeric($value)) {
            return false;
        }

        return floatval($value) >= floatval($parameter);
    }

    protected function minMessage($parameter)
    {
        return 'must be greater than or equal to ' . $parameter;
    }

    /**
     * The value must be LESS THAN (inclusive) the given parameter
     * Fails if value is non-numeric
     */
    protected function max($value, $parameter)
    {
        if (!$this->numeric($value)) {
            return false;
        }

        return floatval($value) <= floatval($parameter);
    }

    protected function maxMessage($parameter)
    {
        return 'must be less than or equal to ' . $parameter;
    }
}