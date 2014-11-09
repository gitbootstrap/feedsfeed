<?php 

header('Content-Type: application/rss+xml; charset=UTF-8');

require_once('inc/autoloader.php');
require_once('config.php');

// http://php.net/manual/en/function.array-search.php#91365
function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

$json    = file_get_contents($feed_source); 
$sources = json_decode($json, true);

if (is_array($sources)) {
  $feeds = array();
  foreach($sources as $source){
      $feeds[] = $source['channel'][$feed_channel];
  }
} else {
  echo "Error: Input is not an array";
  exit;
}

// Set copyright year
if(date("Y") == $feed_launch_year){
   $copyright = "Copyright " . $feed_launch_year;
} else {
   $copyright = "Copyright " . $feed_launch_year."-".date("Y");
}

$xml = <<< END
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" 
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:content="http://purl.org/rss/1.0/modules/content/" 
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:creativeCommons="http://backend.userland.com/creativeCommonsRssModule"
>
  <channel>
    <title>$feed_title</title>
    <atom:link href="$feed_link" rel="self" type="application/rss+xml" />
    <link>$feed_home</link>
    <description>$feed_desc</description>
    <language>$feed_language</language>
    <copyright>$copyright</copyright>
    <creativeCommons:license>http://creativecommons.org/publicdomain/zero/1.0/legalcode</creativeCommons:license>
END;
 
date_default_timezone_set($feed_timezone);
$feed = new SimplePie();

// Load the feeds
$feed->set_feed_url($feeds);
$feed->enable_cache(true);
$feed->set_cache_location('cache');
$feed->set_stupidly_fast(true);
$feed->set_cache_duration ($feed_cache_duration);
$feed->get_raw_data(isset($_GET['xmldump']) ? true : false);
$success = $feed->init();
$feed->handle_content_type();

if ($success) {
  $itemlimit=0;
  foreach($feed->get_items() as $item) {
    if ($itemlimit==$feed_max_items) { break; }

    $title = $item->get_title();
    $permalink = $item->get_permalink();
    $link = $item->get_link();

    // Normalize link
    if (preg_match('/\Ahttps?:\/\/github.com/', $permalink)) {
      $link = preg_replace('/\/(commits|releases)\/(.*)\Z/', null, $permalink );
    } else if (preg_match('/\Ahttps?:\/\/bitbucket.org/', $permalink)) {
      $link = preg_replace('/\/commits\/(.*)\Z/', null, $permalink );
    } else if (preg_match('/\Ahttps?:\/\/plugins.trac.wordpress.org/', $permalink)) {
      $link = preg_replace('/\/changeset\/([0-9]+\/)/', '/log/', $permalink );
      $link .= "?limit=100&mode=stop_on_copy&format=rss";
    }

    $key = recursive_array_search($link, $sources);
    

    if($key == null) {
      continue;
    }
    $project  = $sources[$key]["name"];
    $pub_date = $item->get_date('D, d M Y H:i:s T');

$xml .= <<< END
\n    <item>
      <title>$project $title</title>
      <link>$permalink</link>
      <guid>$permalink</guid>
      <pubDate>$pub_date</pubDate>
    </item>
END;
    $itemlimit = $itemlimit + 1;
  }
}

$xml .=  <<< END
\n</channel>
</rss>
END;

if (strlen($xml) > 0) {
  file_put_contents($feed_filename, $xml, LOCK_EX);
} else {
  echo "Error: No items in feed";
  exit;
}

if(file_exists($feed_filename)) {
  echo "File <a href=\"$feed_filename\">$feed_filename</a> exists";
} else {
  echo "Error: Could not create <code>$feed_filename</code>";
}

?>