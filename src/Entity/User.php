<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column()
     */
    private string $countryCode;

    /**
     * @ORM\Column()
     */
    private string $phoneNumber;

    /**
     * @ORM\Column()
     */
    private string $authyId;

    public function getId()
    : ?int {

        return $this->id;
    }

    public function getEmail()
    : ?string {

        return $this->email;
    }

    public function setEmail(string $email)
    : self {

        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername()
    : string {

        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    : array {

        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    : self {

        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    : string {

        return (string)$this->password;
    }

    public function setPassword(string $password)
    : self {

        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt()
    : ?string {

        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {

        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCountryCode()
    : string {

        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode)
    : void {

        $this->countryCode = $countryCode;
    }

    public function getPhoneNumber()
    : string {

        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber)
    : void {

        $this->phoneNumber = $phoneNumber;
    }

    public function getAuthyId()
    : string {

        return $this->authyId;
    }

    public function setAuthyId(string $authyId)
    : void {

        $this->authyId = $authyId;
    }
}
