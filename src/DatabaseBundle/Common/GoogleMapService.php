<?php

namespace DatabaseBundle\Common;

use DatabaseBundle\Exceptions\LocationNotFoundException;
use DatabaseBundle\Exceptions\ConnectionErrorException;

class GoogleMapService
{
    protected $base_url;
    protected $key;

    public function __construct()
    {
        $key_1 = "AIzaSyAXgntVOg_HxLnDUrWeUqUtswU5Mo0QR7Y";
        $key_2 = "AIzaSyAtlU2iplKVVpv-csBkZC1tlTquBl1UVNo";
        $this->base_url = "https://maps.googleapis.com/maps/api/geocode/json?";
        $this->key = $key_1;
    }
    // address=10+Stockdale+Ave,+Clayton,+VIC&key=AIzaSyAXgntVOg_HxLnDUrWeUqUtswU5Mo0QR7Y

    /**
     * replace "/\s/" to "+"
     *
     * @param string $stringName
     */
    public function replaceString($stringName)
    {
        if (preg_match('/\s/', $stringName)) {
            $stringName = str_replace(' ', '+', $stringName);
            $stringName = str_replace('&', '%26', $stringName);
        }
        return $stringName;
    }

    /**
     * @param $country_region
     * @param $admin_district
     * @param $locality
     * @param $street_no
     * @param $street_name
     * @return mixed
     * @throws ConnectionErrorException
     * @throws LocationNotFoundException
     */
    public function geocodeService($country_region, $admin_district, $locality, $suburb, $street_no, $street_name)
    {
        $country_region = $this->replaceString($country_region);
        $admin_district = $this->replaceString($admin_district);
        $locality = $this->replaceString($locality);
        $suburb = $this->replaceString($suburb);
        $street_name = $this->replaceString($street_name);
        $street_no = $this->replaceString($street_no);
        $address_line = $street_no . "+" . $street_name . ",+" . $suburb . ",+" . $locality . ",+" . $admin_district . ",+" . $country_region;

        $url = $this->base_url . "address=" . $address_line . "&key=" . $this->key;
        // get result from curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch) ? curl_exec($ch) : file_get_contents($url);
        curl_close($ch);

        if (!$result) {
            throw new ConnectionErrorException ();
        }
        // decode JSON result
        $json = json_decode($result);
        $json_found = $json->status;

        if (!$json || $json_found != "OK") {
            throw new LocationNotFoundException ();
        }
        return $json;

    }

    /**
     * get latitude & longitude by address info
     */
    public function getLocation($country_region, $admin_district, $locality, $suburb, $street_no, $street_name)
    {
        $json = $this->geocodeService($country_region, $admin_district, $locality, $suburb, $street_no, $street_name);
        $latitude = $json->results [0]->geometry->location->lat;
        $longitude = $json->results [0]->geometry->location->lng;
        $location = array();
        $location ["latitude"] = $latitude;
        $location ["longitude"] = $longitude;
        return $location;
    }

    /**
     * get Accuate Info of address
     *
     * @param $country_region
     * @param $admin_district
     * @param $locality
     * @param $street_no
     * @param $street_name
     * @return array
     * @throws ConnectionErrorException
     * @throws LocationNotFoundException
     */
    public function getAddress($country_region, $admin_district, $locality, $suburb, $street_no, $street_name)
    {
        $result = array();
        $json = $this->geocodeService($country_region, $admin_district, $locality, $suburb, $street_no, $street_name);
        $address_components = $json->results [0]->address_components;
        $result ['formatted_address'] = $json->results [0]->formatted_address;
        foreach ($address_components as $address_component) {
            $type = $address_component->types[0] == "political" ? $address_component->types[1] : $address_component->types[0];
            $long_name = $address_component->long_name;
            $short_name = $address_component->short_name;
            $result [$type] = ["long_name" => $long_name, "short_name" => $short_name];
        }
        return $result;
    }

}