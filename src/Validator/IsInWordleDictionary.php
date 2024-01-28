<?php
// src/Validator/Constraints/IsInWordleDictionary.php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
#[\Attribute] class IsInWordleDictionary extends Constraint
{
public string $message = 'Le mot "{{ string }}" n\'existe pas dans le dictionnaire Wordle.';

public function validatedBy()
{
return static::class.'Validator';
}
}
