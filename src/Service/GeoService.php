<?php

/**
 * This class has been generated to initialize the database. 
 * It reads every records of routes table and calculates their distance through airports table. 
 */

namespace Application\Service;

class GeoService extends AbstractService
{
    /**
     * This calculates the distance between two give points
     *
     * @param float $lat1 Source latitude
     * @param float $lng1 Source longitude
     * @param float $lat2 Destination latitude
     * @param float $lng2 Destination longitude
     * @param string $unit Unit can be in Kilometers (K), Miles (M) or Nautical Miles (N)
     * @return float Returns the distance between two points
     */
    protected function distance($lat1, $lng1, $lat2, $lng2, $unit = "K") {
        
        $delta = $lng1 - $lng2;
        $distance = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($delta));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $miles = $distance * 60 * 1.1515;
        $unit = strtoupper($unit);
        
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    /**
     * This returns distance between two given nodes.
     *
     * @param string $src
     * @param string $dst
     * @return float
     */
    public function getDistance($src, $dst)
    {
        $result = $this->getDatabaseManager()->airports()->select('id, code, lat, lng')->where(['code' => [$src, $dst]]);
        $row    = [];
        foreach($result as $airport) {
            $data = $airport->getData();
            if (isset($data['code'])) {
                $row[$data['code']] = ['lat' => $data['lat'], 'lng' => $data['lng']];
            }
        }

        if (count($row) == 2) {
            return $this->distance($row[$src]['lat'], $row[$src]['lng'], $row[$dst]['lat'], $row[$dst]['lng']);
        }

        return false;
    }

    /**
     * Store the calculated distance between two points.
     *
     * @param float] $src
     * @param float $dst
     * @return null|\PDOStatement
     */
    public function setDistance($src, $dst)
    {
        $result = $this->getDatabaseManager()->routes()->where('src=? AND dst=?', $src, $dst);

        return $result->update(['distance' => $this->getDistance($src, $dst)]);
    }
}
