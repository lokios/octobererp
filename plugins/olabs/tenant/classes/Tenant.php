<?php

namespace Olabs\Tenant\Classes;

use Model;
use BackendAuth;
use Backend;
use Config;
use Event;
use Cache;
use Request;
use App;
use Flash;
use Olabs\Tenant\Models\Organizations;

class Tenant {

    public static function toAddressText($org) {

        $a = array();
        if (isset($org['address_1'])) {
            $a[] = $org['address_1'];
        }
        if (isset($org['address_2'])) {
            $a[] = $org['address_2'];
        }
        if (isset($org['city'])) {
            $a[] = $org['city'];
        }
        if (isset($org['state'])) {
            $a[] = $org['state'];
        }
        if (isset($org['country'])) {
            $a[] = $org['country'];
        }

        return implode(", ", $a);
    }

    /**
     * @return mixed
     * Returns session org based on requested domain name
     *
     */
    public static function getOrg() {
        $backendUri = Config::get('cms.backendUri');
        $requestUrl = Request::url();
        $currentHostUrl = Request::getHost();
        $currentHostUrl = str_ireplace("dev.", "", $currentHostUrl);
        $currentHostUrl = str_ireplace("www.", "", $currentHostUrl);
        $currentHostUrl = str_ireplace("http://", "", $currentHostUrl);
        $currentHostUrl = str_ireplace("https://", "", $currentHostUrl);

        $org = Organizations::where('config_url', $currentHostUrl)->first();
        if ($org)
            return $org;

        $e = explode(".", $currentHostUrl);
        $dname = strtolower($e[0]);
        $org = Organizations::where('dname', $dname)->first();
        if ($org)
            return $org;


        return false;
    }

    /**
     * @return mixed
     * Returns backend users org
     */
    public static function getUserOrgId() {
        $org = self::getOrg();
        if (!$org)
            return false;
        return $org->id;
    }

    public static function getHost() {
        $backendUri = Config::get('cms.backendUri');
        $requestUrl = Request::url();
        $currentHostUrl = Request::getHost();
        return $currentHostUrl;
        return Organizations::where('config_url', $currentHostUrl)->first();
    }

}
