<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Run some tests and display their results.
 *
 * @category Geocoding
 * @package  Geocoding
 * @author   Ignatius Yesigye <ignatiusyesigye@gmail.com>
 * @license  MIT <http://opensource.org/licenses/MIT>
 * @link     null
 */
class Geocoding
{
    /**
     * Getting visitors location from their IP
     * 
     * Service: http://www.geoplugin.net
     * 
     * Usage:
     * echo ip_info("173.252.110.27", "Country"); // United States
     * echo ip_info("173.252.110.27", "Country Code"); // US
     * echo ip_info("173.252.110.27", "State"); // California
     * echo ip_info("173.252.110.27", "City"); // Menlo Park
     * echo ip_info("173.252.110.27", "Address"); // Menlo Park, California, United States
     * print_r(ip_info("173.252.110.27", "Location")); // Array ( [city] => Menlo Park [state] => California [country] => United States [country_code] => US [continent] => North America [continent_code] => NA )
     *
     * @param string $ip visitor's IP address
     * @param string $purpose segment of data to return
     * @param boolean $deep_detect follow node servers
     *
     * @return mixed 
     **/
    function ip_info($ip = "", $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {

            $rCURL = curl_init();
            curl_setopt($rCURL, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=$ip");
            curl_setopt($rCURL, CURLOPT_HEADER, 0);
            curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
            $aData = curl_exec($rCURL);
            curl_close($rCURL);

            $ipdat = @json_decode($aData);
            
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
}