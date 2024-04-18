<?php

namespace App\Person\Application;

use App\Shared\Domain\Gender;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class PersonCreateCommand
{
    #[NotBlank]
    private ?string $name = '';

    #[NotBlank]
    #[Email(message: 'Email {{ value }} не является валидным email')]
    private string $email;

    #[Date]
    private ?string $birthday = null;

    #[Type(Gender::class)]
    private ?Gender $sex = null;

    #[Regex([
        'pattern' => '/^[0-9]\d*$/',
        'message' => 'Please use only positive numbers.'
    ])]
    #[Length(
        min: 7,
        max: 10,
        minMessage: 'Your phone must be at least {{ limit }} characters long',
        maxMessage: 'Your phone cannot be longer than {{ limit }} characters'
    )]
    private ?string $phone = null;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getSex(): ?Gender
    {
        return $this->sex;
    }

    public function setSex(?Gender $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
