<?php
/**
 * @category GeoHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  7/8/15 10:56
 * @since
 */
namespace qiqi\helper\geo;

/**
 * Class GeoHelper
 *
 * @package common\core\geo
 */
class GeoHelper
{
    const PI = 3.14159265358979324 * 3000.0 / 180.0;

    /**
     * @param     $lat
     * @param     $lng
     * @param int $length
     *
     * @return string
     */
    static public function getGeoHash($lat, $lng, $length = 12)
    {
        $tools = new GeoHash();

        return $tools->encode($lat, $lng, $length);
    }

    static public function getDistanceByCoordinate($c1, $c2)
    {
        list($lat, $lng) = explode(",", $c1);
        list($lat1, $lng1) = explode(",", $c2);

        return self::getDistance($lat, $lng, $lat1, $lng1);
    }

    static public function getDistance($lat, $lng, $lat1, $lng1)
    {
        $tools = new Geotools();
        $from = new Coordinate([$lat, $lng]);
        $to = new Coordinate([$lat1, $lng1]);
        $distance = $tools->distance()->setFrom($from)->setTo($to)->in('km')->haversine();
        if($distance < 1){
            return number_format($distance, 1) * 100 . " m";
        }

        return ceil($distance) . " km";
    }

    static public function bdToGcj($lat, $lng)
    {
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * self::PI);
        $theta = atan2($y, $x) - 0.000003 * cos($x * self::PI);

        return ['lat' => $z * sin($theta), 'lng' => $z * cos($theta)];
    }

    static public function gcjTobd($lat, $lng)
    {
        list($x, $y) = [$lng, $lat];
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * self::PI);
        $theta = atan2($y, $x) - 0.000003 * cos($x * self::PI);

        return [
            'lat' => $z * sin($theta) + 0.006,
            'lng' => $z * cos($theta) + 0.0065,
        ];
    }
}
