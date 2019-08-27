<?php


namespace OmsBundle\Service\Encryiption;


class ArgonService implements EncriptionServiceInteface
{

    public function hash(string $password)
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    public function verify(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }
}