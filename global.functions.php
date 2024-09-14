<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

if (!function_exists('setEnvValue')) {

    /**
     * setEnvValue function.
     *
     * @access public
     * @param string $path (default: '')
     * @return void
     */
    function setEnvValue(array $values)
    {

        $envFile = app()->environmentFilePath();
        $str = File::get($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!File::put($envFile, $str)) return false;
        return true;
    }
}

if(!function_exists('pr')){

    /**
     * pr function.
     *
     * @access public
     * @param mixed $value
     * @return void
     */
    function pr($value){
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}

if (! function_exists('routeIs')) {

    /**
     * routeIs function.
     *
     * @param  bool  $key  (default: false)
     * @return void
     */
    function routeIs($arg, $class = null)
    {
        return Route::is($arg) ? (! is_null($class) ? $class : true) : false;
    }
}

/**
 * Format phone number to standard US
 *
 * @param string $data 9161234567
 * @return string (916) 123-4567
 */
if (! function_exists('phone')) {
    function phone($data)
    {
        if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $data, $matches)) {
            $result = "({$matches[1]})" . ' ' .$matches[2] . '-' . $matches[3];
            return $result;
        }
    }
}



/**
 * Format date string as Carbon instance
 *
 * @param mixed $date Can be Carbon instance, DateTime instance, date string, or unix timestamp
 * @param string $format Date string to format into. If null, will return Carbon instance
 * @uses App\User::timezone to retrieve the user's timezone
 * @return mixed Will return formatted date string If format is not null, otherwise will return Carbon instance
 */
if (! function_exists('carbon')) {
    function carbon($date, string $format = null)
    {
        $carbonized = null;

        // setup carbon instance
        if ($date instanceof \Carbon\Carbon) {
            $carbonized = $date;
        } else if ($date instanceof \DateTime) {
            $carbonized = Carbon::parse($date);
        } else if (@strtotime($date) && strtotime($date) != '1969-12-31') {
            $carbonized = Carbon::parse($date);
        } else if ( is_numeric($date) ) {
            $carbonized = Carbon::parse($date);
        } else {
            return null;
        }

        // setup timezone
        $carbonized->settings(['timezone' => config('app.timezone', 'UTC')]);

        // update timezone
        if ( $carbonized !== null ) {
            if (auth()->check() && auth()->user()->timezone !== null) {
                $carbonized->setTimezone(auth()->user()->timezone);
            }
        }

        //format
        if ($format != null) {
            return $carbonized->format($format);
        }

        return $carbonized;
    }
}

/**
 * Simply echos selected on select fields
 *
 * @param string|integer $val1 The first value to compare
 * @param string|integer $val2 The second value to compare
 * @return void Will echo selected if equal, otherwise nothing
 */
if (! function_exists('selected')) {
    function selected($val1, $val2)
    {
        if ($val1 == $val2) {
            echo 'selected="selected"';
        }
    }
}

/**
 * Simply echos checked on input fields
 *
 * @param string|integer $val1 The first value to compare
 * @param string|integer $val2 The second value to compare
 * @return void Will echo selected if equal, otherwise nothing
 */
if (! function_exists('checked')) {
    function checked($val1, $val2)
    {
        if ($val1 == $val2) {
            echo 'checked="checked"';
        }
    }
}



if (! function_exists('get_countries')) {
    function get_countries()
    {
        return [
        'US' => 'United States',
        'CA' => 'Canada',
        'MX' => 'Mexico',
        'AF' => 'Afghanistan',
        'AX' => 'Åland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua & Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia & Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'VG' => 'British Virgin Islands',
        'BN' => 'Brunei',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CV' => 'Cape Verde',
        'BQ' => 'Caribbean Netherlands',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo - Brazzaville',
        'CD' => 'Congo - Kinshasa',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Côte d’Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CW' => 'Curaçao',
        'CY' => 'Cyprus',
        'CZ' => 'Czechia',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'SZ' => 'Eswatini',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard & McDonald Islands',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong SAR China',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Laos',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao SAR China',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'FM' => 'Micronesia',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar (Burma)',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'KP' => 'North Korea',
        'MK' => 'North Macedonia',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territories',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn Islands',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Réunion',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'RW' => 'Rwanda',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'São Tomé & Príncipe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SX' => 'Sint Maarten',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia & South Sandwich Islands',
        'KR' => 'South Korea',
        'SS' => 'South Sudan',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'BL' => 'St. Barthélemy',
        'SH' => 'St. Helena',
        'KN' => 'St. Kitts & Nevis',
        'LC' => 'St. Lucia',
        'MF' => 'St. Martin',
        'PM' => 'St. Pierre & Miquelon',
        'VC' => 'St. Vincent & Grenadines',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard & Jan Mayen',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syria',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad & Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks & Caicos Islands',
        'TV' => 'Tuvalu',
        'UM' => 'U.S. Outlying Islands',
        'VI' => 'U.S. Virgin Islands',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VA' => 'Vatican City',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'WF' => 'Wallis & Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    ];
    }
}

/**
 * Simply a list of US states
 *
 * @return array Array of the US states
 */
if (! function_exists('get_states')) {
    function get_states()
    {
        return [
            "AK" => "Alaska",
            "AL" => "Alabama",
            "AR" => "Arkansas",
            "AS" => "American Samoa",
            "AZ" => "Arizona",
            "CA" => "California",
            "CO" => "Colorado",
            "CT" => "Connecticut",
            "DC" => "District of Columbia",
            "DE" => "Delaware",
            "FL" => "Florida",
            "GA" => "Georgia",
            "GU" => "Guam",
            "HI" => "Hawaii",
            "IA" => "Iowa",
            "ID" => "Idaho",
            "IL" => "Illinois",
            "IN" => "Indiana",
            "KS" => "Kansas",
            "KY" => "Kentucky",
            "LA" => "Louisiana",
            "MA" => "Massachusetts",
            "MD" => "Maryland",
            "ME" => "Maine",
            "MI" => "Michigan",
            "MN" => "Minnesota",
            "MO" => "Missouri",
            "MS" => "Mississippi",
            "MT" => "Montana",
            "NC" => "North Carolina",
            "ND" => "North Dakota",
            "NE" => "Nebraska",
            "NH" => "New Hampshire",
            "NJ" => "New Jersey",
            "NM" => "New Mexico",
            "NV" => "Nevada",
            "NY" => "New York",
            "OH" => "Ohio",
            "OK" => "Oklahoma",
            "OR" => "Oregon",
            "PA" => "Pennsylvania",
            "PR" => "Puerto Rico",
            "RI" => "Rhode Island",
            "SC" => "South Carolina",
            "SD" => "South Dakota",
            "TN" => "Tennessee",
            "TX" => "Texas",
            "UT" => "Utah",
            "VA" => "Virginia",
            "VI" => "Virgin Islands",
            "VT" => "Vermont",
            "WA" => "Washington",
            "WI" => "Wisconsin",
            "WV" => "West Virginia",
            "WY" => "Wyoming"
        ];
    }
}

/**
 * Get suffix of a number
 *
 * @param int $number 50
 * @return string The number and suffix
 */
if (! function_exists('number_suffix')) {
    function number_suffix($number)
    {
        if ($number == null) {
            return;
        }
        if (! is_numeric($number)) {
            return $number;
        }
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        $mod = $number % 100;
        // 11th, 12th, 13th
        if ($mod >= 11 && $mod <= 13) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }
}

if (! function_exists('min_1')) {
    function min_1($number)
    {
        if (empty($number)) {
            return 1;
        }

        if ($number == '0.00') {
            return 1;
        }

        return $number;
    }
}

if (! function_exists('isJson')) {
    function isJson($string)
    {
        json_decode($string);

        return json_last_error() == JSON_ERROR_NONE;
    }
}

if (! function_exists('fileFaIcon')) {
    function fileFaIcon($extension)
    {
        switch (strtolower($extension)) {
            case 'pdf':
                return 'pdf';

            case 'document':
            case 'docx':
            case 'doc':
            case 'txt':
                return 'word';

            case 'csv':
            case 'xls':
            case 'xlsx':
            case 'numbers':
            case 'spreadsheet':
                return 'spreadsheet';

            case 'mp3':
            case 'ogg':
            case 'wav':
                return 'audio';

            case 'mp4':
            case 'mov':
                return 'video';

            case 'zip':
            case '7z':
            case 'rar':
            case 'tar':
            case 'dmg':
                return 'archive';

            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'svg':
            case 'psd':
                return 'image';

            case 'ppt':
            case 'pptx':
            case 'presentation':
                return 'presentation';

            default:
                return 'alt';
        }
    }
}

if (! function_exists('byteFormat')) {
    function byteFormat($bytes) {
        if(empty($bytes)) { return ''; }
        $i = floor(log($bytes, 1000));
        return round($bytes / pow(1000, $i), [0,0,2,2,3][$i]). ' ' . ['B','KB','MB','GB','TB'][$i];
    }
}

if (!function_exists('setting')) {
    function setting($key = false, $defaultValue = false) {
        $setting = app('Setting');

        if ($key === false) {
            return $setting;
        }

        $value = $setting->get($key);

        return $value ? $value : $defaultValue;
    }
}
