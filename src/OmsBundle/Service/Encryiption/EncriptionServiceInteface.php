<?php


namespace OmsBundle\Service\Encryiption;


interface EncriptionServiceInteface
{
    public function hash(string $password);
    public function verify(string $password, string $hash);
}