<?php

namespace App\Service;

use App\Repository\TokenPriceRepository;

class MoneroPaymentService {

    private $tokenPriceRepository;

    public function __construct(TokenPriceRepository $tokenPriceRepository){
        $this->tokenPriceRepository = $tokenPriceRepository;
    }

    public function generatePaymentId(): string
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, 16);
    }

    public function getMoneroPriceEUR()
    {
        return $this->tokenPriceRepository->findOneBy(['name' => 'XMR'])->getPrice();
    }
}
