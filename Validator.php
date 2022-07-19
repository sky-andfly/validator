<?php


class Validator{

    const PASSWORD_LEN = 8;
    const NumberInPassword = true;
    const DATE_SEPARATOR = '/';

    protected array $errors = [];
    protected array $fields;
    protected string $field;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
    public function getField($field_name): static
    {
        $this->field = $this->fields[$field_name];
        return $this;
    }
    public function phone($regular = null): static
    {
        $regular = ($regular == null) ? 'rus' : $regular;

        $regulars = [
            'rus' => '/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/',
            'usa' => '/^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}$/',
            'kz' => '/^\+?77(\d{9})$/',
        ];
        if(array_key_exists($regular, $regulars))
        {
            if (!preg_match($regulars[$regular], $this->field))
            {
                $this->errors[] = "number: invalid";
            }

        }else{
            $this->errors[] = "number: The key is missing";
        }
        return $this;


    }
    public function email(): static
    {

        if (!filter_var($this->field, FILTER_VALIDATE_EMAIL))
        {

            $this->errors[] =  "email: No validate";
        }

        return $this;
    }
    public function displayErrors(): void
    {
        echo "<pre>";
        var_dump($this->errors);
        echo "</pre>";
    }
    public function checkPassword(): static
    {
        if(strlen($this->field) < self::PASSWORD_LEN){
            $this->errors[] = "password: too short!";
        }
        if (!preg_match("#[0-9]+#", $this->field) && self::NumberInPassword) {
            $this->errors[] = "password: must include at least one number!";
        }
        return $this;
    }
    public function repeatPassword($field): static
    {
        if($this->field != $this->fields[$field]){
            $this->errors[] = "password: passwords are different!";
        }
      return  $this;
    }
    public function validateDate($date): bool
    {
        $sep = self::DATE_SEPARATOR;
        $format = "Y{$sep}m{$sep}d";
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    public function date(): static
    {
        if(!$this->validateDate($this->field)){
            $this->errors[] = 'date: invalid';
        }
        return $this;
    }
    public function notEmpty():static{
        if(empty($this->field)){
            $this->errors[] =   "empty";
        }
        return $this;
    }
    public function validity():bool
    {
        if (empty($this->errors)){
            return true;
        }
        return false;
    }
}