<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Bid;
use App\Repository\BidRepository;

class BidManager
{
    /**
     * @var BidRepository
     */
    private BidRepository $bidRepository;

    /**
     * @param BidRepository $bidRepository
     */
    public function __construct(BidRepository $bidRepository)
    {
        $this->bidRepository = $bidRepository;
    }

    /**
     * @return array|Bid
     */
    public function getAll(): array
    {
        return $this->bidRepository->findAll();
    }

    /**
     * @param string $id
     * @return Bid
     */
    public function get(string $id): Bid
    {
        return $this->bidRepository->find($id);
    }
}