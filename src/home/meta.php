<?php
if (!defined('IN_CRONLITE')) return;
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title><?php echo $page_title ?? $conf['title']; ?></title>
    <meta name="keywords" content="<?php echo $keywords ?? $conf['keywords']; ?>">
    <meta name="description" content="<?php echo $description ?? $conf['description']; ?>">
    <link rel="shortcut icon" type="images/x-icon" href="./favicon.ico" />
    <link rel="stylesheet" href="<?php echo $site_cdnpublic; ?>font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/ozui.min.css" />
<?php
    $themeMetaFile = ROOT . '/templates/' . $conf['theme'] . '/meta.php';
    if (file_exists($themeMetaFile)) {
        require($themeMetaFile);
    } else {
        echo '<link rel="stylesheet" type="text/css" href="./templates/' . $conf['theme'] . '/css/style.css?v=' . $conf['themeVersion'] .'" />';
    }
    echo $conf['script_header'];
?>
