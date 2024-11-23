<?php
ini_set("memory_limit", "2048M");
#playlist function
function playlist($playlistfile)
{
    if (empty($json_playlist = json_decode(curl($playlistfile), true))) {
        echo '["Error loading playlist"]';
    } else {
        #curl json.playlist to array $json_playlist
        #fmt_stream_map for each
        $fmt_stream_map = array_column($json_playlist, "sources");
        foreach ($fmt_stream_map as &$value) {
            $value = urldecode($value);
            preg_match("/(?:https?:\/\/)?(?:[\w\-]+\.)*(?:drive|docs)\.google\.com\/(?:(?:folderview|open|uc)\?(?:[\w\-\%]+=[\w\-\%]*&)*id=|(?:folder|file|document|presentation)\/d\/|spreadsheet\/ccc\?(?:[\w\-\%]+=[\w\-\%]*&)*key=)([\w\-]{28,})/i", $value, $match);
            $value = json_decode(curl("https://api.getlinkdrive.com/getlink?url=" . $value), true);
            #remove "src","res" and re-value label
            foreach (array_keys($value) as &$key) {
                $value[$key]["label"] = str_ireplace("p", "", $value[$key]["label"]);
                unset($value[$key]["src"], $value[$key]["res"]);
            }
            #ksort array
            foreach ($value as $label => &$quality) {
                $ksort_array[$label] = $quality["label"];
            }
            array_multisort($ksort_array, SORT_DESC, $value);
            #replace sources and add preview
            $value = array('sources' => $value, 'fileId' => $match["1"]);
        }
        #combine $fmt_stream_map into $json_playlist
        $playlist = array_replace_recursive($json_playlist, $fmt_stream_map);
        #print $playlist by json
        echo json_encode($playlist, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
#curl function
function curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    return curl_exec($ch);
    curl_close($ch);
    #delay 0.25 sec = 250000 
    usleep(250000);
}
#urlhttps function
function urlhttps()
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        echo urldecode("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    } else {
        echo urldecode("http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    }
}
