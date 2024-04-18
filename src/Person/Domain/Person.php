<?php

namespace App\Person\Domain;

use App\Person\Application\PersonCreateCommand;
use App\Person\Application\PersonItem;
use App\Person\Application\PersonUpdateCommand;
use App\Person\Infrastructure\PersonRepository;
use App\Shared\Domain\Gender;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Пользователь с таким email уже существует!')]
class Person
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?DateTimeImmutable $birthday = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?Gender $sex = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $deletedAt = null;

    private function __construct()
    {
    }


    /**
     * @throws Exception
     */
    public static function fromCreateRequest(PersonCreateCommand $model): self
    {
        $birthday = $model->getBirthday() ? new DateTimeImmutable($model->getBirthday()) : null;

        return (new self())
            ->setName($model->getName())
            ->setEmail($model->getEmail())
            ->setBirthDay($birthday)
            ->setSex($model->getSex())
            ->setPhone($model->getPhone())
            ->setCreatedAt(new DateTimeImmutable())
            ;
    }

    /**
     * @throws Exception
     */
    public static function fromUpdateRequest(Person $person, PersonUpdateCommand $model): self
    {
        $birthday = $model->getBirthday() ? new DateTimeImmutable($model->getBirthday()) : null;

        return $person
            ->setName($model->getName())
            ->setBirthDay($birthday)
            ->setSex($model->getSex())
            ->setPhone($model->getPhone())
            ->setUpdatedAt(new DateTimeImmutable());
    }

    public function toResponseItem(): PersonItem
    {
        return (new PersonItem())

            ->setId($this->getId())
            ->setName($this->getName())
            ->setEmail($this->getEmail())
            ->setBirthDay($this->getBirthday())
            ->setAge($this->getAge())
            ->setSex($this->getSex()?->value)
            ->setPhone($this->getPhone())
            ->setCreatedAt($this->getCreatedAt())
            ->setUpdatedAt($this->getUpdatedAt())
            ;
    }

    public function makeDeleted(): void
    {
        $this->setDeletedAt(new DateTimeImmutable());
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    private function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    private function getBirthday(): ?string
    {
        return $this->birthday?->format('d-m-Y');
    }

    private function setBirthday(?DateTimeImmutable $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    private function getAge(): ?string
    {
        $now = new DateTimeImmutable();
        return $this->birthday ? $now->diff($this->birthday)->y : '';
    }

    private function getSex(): ?Gender
    {
        return $this->sex;
    }

    private function setSex(?Gender $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    private function getPhone(): ?string
    {
        return $this->phone;
    }

    private function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    private function getCreatedAt(): ?string
    {
        return $this->createdAt?->format('d-m-Y');
    }

    private function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    private function getUpdatedAt(): ?string
    {
        return $this->updatedAt?->format('d-m-Y');
    }

    private function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    private function getDeletedAt(): ?string
    {
        return $this->deletedAt?->format('d-m-Y');
    }

    private function setDeletedAt(?DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
