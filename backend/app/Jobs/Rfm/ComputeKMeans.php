<?php

namespace App\Jobs\Rfm;

use App\Models\Data;
use App\Services\DTO\RfmDTO;
use Illuminate\Support\Facades\Auth;
use Closure;
use Phpml\Clustering\KMeans;

class ComputeKMeans
{
    /**
     * @param RfmDTO $rfmDTO
     * @param Closure $next
     * @return mixed
     * @throws \Phpml\Exception\InvalidArgumentException
     */
    public function handle(RfmDTO $rfmDTO, Closure $next)
    {
        $dataset = $this->getDataset($rfmDTO->getRfmTable());
        $kmeans = new KMeans(4);

        $clusters = $kmeans->cluster($dataset);

        foreach ($clusters as $key => $cluster) {
            foreach ($cluster as $email => $item) {
                Data::where('user_id', Auth::id())->where('email', $email)->update([
                    'kmeans' => $key + 1
                ]);
            }
        }

        return $next($rfmDTO);
    }

    /**
     * @param array $rfmTable
     * @return array
     */
    protected function getDataset(array $rfmTable): array
    {
        $dataset = [];
        foreach ($rfmTable as $item) {
            $dataset[$item['email']] = [$item['recency'], $item['frequency'], $item['monetary']];
        }

        return $dataset;
    }
}
