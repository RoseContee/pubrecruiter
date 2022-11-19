<?php
const INFLUENCERS = [
    'www.youtube.com',  //https://www.youtube.com/channel/*USERNAME*, https://www.youtube.com/user/*USERNAME*, https://www.youtube.com/c/*USERNAME*
    'www.facebook.com', //https://www.facebook.com/groups/*USERNAME*, https://www.facebook.com/*USERNAME*
    'twitter.com',      //https://twitter.com/*USERNAME*
    'www.tiktok.com'    //https://www.tiktok.com/@*USERNAME*
];

const INFLUENCER_PATTERNS = [
    'www.youtube.com' => [
        'https://www.youtube.com/channel/',
        'https://www.youtube.com/user/',
        'https://www.youtube.com/c/',
    ],
    'www.facebook.com' => [
        'https://www.facebook.com/groups/',
        'https://www.facebook.com/',
    ],
    'twitter.com' => [
        'https://twitter.com/'
    ],
    'www.tiktok.com' => [
        'https://www.tiktok.com/@'
    ]
];


/**
 * @param $url
 * @param null $html
 * @return mixed
 */
function getURL($url, &$html = null) {
    try {
        $options = [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => [
                "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36",
            ],
            CURLOPT_HEADER => true,
        ];
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $real_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        if (!$real_url) $real_url = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
        curl_close($ch);
        $html = substr($response, $header_size);
    } catch (Exception $exception) {}
    return $real_url ?? $url;
}

/**
 * @param $domain
 * @param $html
 * @return bool
 */
function checkInfluencer($domain, $html) {
    $domDocument = new \DOMDocument();
    libxml_use_internal_errors(true);
    $domDocument->loadHTML($html);
    $meta = $domDocument->getElementsByTagName('meta');
    if (in_array($domain, ['www.youtube.com', 'twitter.com'])) {
        for ($i = 0; $i < $meta->length; $i++) {
            $node = $meta->item($i);
            if ($node->getAttribute('property') == 'og:type'
                && $node->getAttribute('content') == 'profile') {
                return true;
            }
        }
    } else if ($domain == 'www.facebook.com') {
        $div = $domDocument->getElementsByTagName('div');
        for ($i = 0; $i < $div->length; $i++) {
            $node = $div->item($i);
            if ($node->getAttribute('data-pagelet') == 'ProfileTabs'
                || $node->getAttribute('aria-label') == 'Message'
            ) {
                return true;
            }
        }
        for ($i = 0; $i < $meta->length; $i++) {
            $node = $meta->item($i);
            if ($node->getAttribute('property') == 'al:android:url'
                && stripos($node->getAttribute('content'), 'fb://group/') !== false) {
                return true;
            }
        }
    } else if ($domain == 'www.tiktok.com') {
        for ($i = 0; $i < $meta->length; $i++) {
            $node = $meta->item($i);
            if ($node->getAttribute('property') == 'al:android:url'
                && $node->getAttribute('content') == 'snssdk1233://user/profile/') {
                return true;
            }
        }
    }
    return false;
}

/**
 * @param $url
 * @param false $influencer
 * @return string
 */
function getDomain($url, &$influencer = false) {
    $real_url = getURL($url, $html);
    $url = parse_url($real_url);
    $scheme = isset($url['scheme']) ? $url['scheme'].'://' : '';
    $host = $url['host'] ?? '';
    $port = isset($url['port']) ? ':'.$url['port'] : '';
    $user = $url['user'] ?? '';
    $pass = isset($url['pass']) ? ':'.$url['pass'] : '';
    $pass = ($user || $pass) ? "$pass@" : '';
    $path = rtrim($url['path'] ?? '', '/\\');
    $query = isset($url['query']) && $url['query'] ? '?'.$url['query'] : '';
    $fragment = isset($url['fragment']) ? '#'.$url['fragment'] : '';
    $domain = $host;
    if (in_array($domain, INFLUENCERS)) {
        $influencer = true;
        $domain = null;
        //https://www.youtube.com/channel/USERNAME
        //https://www.youtube.com/user/USERNAME
        //https://www.youtube.com/c/USERNAME
        if ($host == 'www.youtube.com' &&
            checkInfluencer($host, $html) &&
            ((stripos($path, '/channel/') === 0 && ($pos = 9))
                || (stripos($path, '/user/') === 0 && ($pos = 5))
                || (stripos($path, '/c/') === 0 && ($pos = 3)))
        ) {
            if (($pos = stripos($path, '/', $pos)) > 0) {
                $path = substr($path, 0, $pos - 0 + 1);
            }
            $domain = $scheme.$user.$pass.$host.$port.$path;
        //https://www.facebook.com/USERNAME
        //https://www.facebook.com/groups/USERNAME
        } else if ($host == 'www.facebook.com' &&
            ((checkInfluencer($host, $html) && ($pos = 1))
            || (stripos($path, '/groups/') === 0 && ($pos = 8)))
        ) {
            if (($pos = stripos($path, '/', $pos)) > 0) {
                $path = substr($path, 0, $pos + 1);
            }
            if (stripos($path, '/profile.php') === 0) {
                parse_str($url['query'] ?? '', $params);
                if (!empty($params['id'])) {
                    $path = '/profile.php?id='.$params['id'];
                }
            }
            $domain = $scheme.$user.$pass.$host.$port.$path;
        //https://twitter.com/USERNAME
        } else if ($host == 'twitter.com' &&
            checkInfluencer($host, $html) &&
            ($pos = 1)
        ) {
            if (($pos = stripos($path, '/', $pos)) > 0) {
                $path = substr($path, 0, $pos + 1);
            }
            $domain = $scheme.$user.$pass.$host.$port.$path;
        //https://www.tiktok.com/@USERNAME
        } else if ($host == 'www.tiktok.com' &&
            checkInfluencer($host, $html) &&
            stripos($path, '/@') === 0 &&
            ($pos = 2)
        ) {
            if (($pos = stripos($path, '/', $pos)) > 0) {
                $path = substr($path, 0, $pos + 1);
            }
            $domain = $scheme.$user.$pass.$host.$port.$path;
        }
    }
    return $domain;
}

/**
 * @param $n
 * @return string
 */
function number_short_format($n) {
    for ($i = 0; $i < 2; $i++) {
        if ($n >= 1000) $n /= 1000;
        else break;
    }
    $symbol = ['', 'K', 'M'];
    if (!is_int($n)) $n = (int)($n * 10) / 10;
    return $n.$symbol[$i];
}

function short_format_number($n) {
    if (stripos($n, 'K') !== false) {
        $n = str_ireplace('K', '', $n) * 1000;
    } else if (stripos($n, 'M') !== false) {
        $n = str_ireplace('M', '', $n) * 1000000;
    }
    return $n;
}
