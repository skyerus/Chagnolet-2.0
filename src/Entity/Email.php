<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 */
class Email
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length = 100)
     */
    private $name;

    /**
     * @ORM\Column(type="string",length = 100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
     private $message;


    /**
     * @ORM\Column(type="email",length=100)
     */

    public function getId()
    {
        return $this->id;
    }

    // GETTER methods

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getNom() {
        return $this->nom;
    }

    // SETTER methods

    public function setName($name){
        $this->name = $name;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }
}
