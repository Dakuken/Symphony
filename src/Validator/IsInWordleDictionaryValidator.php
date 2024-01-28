<?php

// src/Validator/Constraints/IsInWordleDictionaryValidator.php

namespace App\Validator;

use App\Entity\WordleDictionary;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class IsInWordleDictionaryValidator extends ConstraintValidator
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsInWordleDictionary) {
            throw new UnexpectedTypeException($constraint, IsInWordleDictionary::class);
        }

        if (!$value) {
            return; // Si le champ est vide, d'autres contraintes s'appliqueront
        }

        // Vérifiez si le mot existe dans wordle_dictionary
        $wordExists = $this->entityManager->getRepository(WordleDictionary::class)->findOneBy(['word' => $value]);

        if (!$wordExists) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
