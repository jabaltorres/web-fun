<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;
use mysqli_result;
use RuntimeException;

class RankingService
{
    private DatabaseConnection $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    /**
     * Get all rankings from the database
     *
     * @return array
     * @throws RuntimeException if query fails
     */
    public function getAllRankings(): array
    {
        $sql = "SELECT rank_id, rank_description FROM rankings ORDER BY rank_description";
        $result = $this->db->query($sql);

        if (!$result) {
            throw new RuntimeException('Failed to fetch rankings');
        }

        $rankings = [];
        while ($row = $result->fetch_assoc()) {
            $rankings[] = $row;
        }
        $result->free();

        return $rankings;
    }
} 