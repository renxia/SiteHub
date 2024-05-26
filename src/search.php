<?php
require('./includes/common.php');
require('./includes/lang.class.php');

$keyword = _get('keyword');
if (empty($keyword)) {
    exit('<script type="text/javascript">window.location.href="index.html";</script>');
};

$results = $DB->findAll('site', '*', "`name` LIKE '%$keyword%' OR `url` LIKE '%$keyword%' OR `introduce` LIKE '%$keyword%'", 'lid ASC', 50);
$count = count($results);
$site_list_rank = $DB->findAll('site', '*', null, 'hits_total desc', 10);
$page_title = '站内搜索 -' . $conf['title'];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title><?php echo $page_title; ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords']; ?>">
    <meta name="description" content="<?php echo $conf['description']; ?>">
    <link rel="shortcut icon" type="images/x-icon" href="./favicon.ico" />
    <link href="./assets/fontawesome/4.7.0/css/fontawesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="./assets/css/ozui.min.css" />
    <link rel="stylesheet" type="text/css" href="./templates/<?php echo $conf['theme']; ?>/css/style.css?v=<?php echo $conf['themeVersion']; ?>" />
    <?php echo $conf['script_header']; ?>

</head>

<body class="search-page">
<?php require('./home/header.php'); ?>
<?php require('./home/banner.php'); ?>
<?php require('./home/sidebar.php'); ?>

<div class="container">
    <div class="main">
        <div class="card board">
            <span class="icon"><i class="fa fa-map-signs fa-fw"></i></span>
            <span><a href="./">导航首页</a>&nbsp;»&nbsp;</span>
            <span>搜索 <?php echo $keyword; ?> 的结果</span>
        </div>
        <div id="<?php echo $keyword; ?>" class="card link-card">
            <div class="card-head"><i class="fa fa-search fa-fw"></i>搜索 <span class="keyword"><?php echo $keyword; ?></span> 的结果 (<b class="count"><?php echo $count; ?></b>)</div>
            <div class="card-body flex">
                <?php if ($count == 0) { ?>
                    <div class="content"><h3>暂无搜索结果，请尝试更换关键词重新搜索！</h3></div>
                <?php } else { foreach($results as $rows) { ?>
                    <div class="item">
                        <a class="link-box" href="<?php echo "site-{$rows['id']}.html"; ?>" target="_blank" title="<?php echo $rows['name']; ?>" data-id="<?php echo $rows['id']; ?>">
                            <h3 class="item-title">
                                <span class="icon"><img class="lazy-load" src="assets/images/loading.gif" data-src="<?php echo $rows['img']; ?>"></span>
                                <span class="name"><?php echo $rows['name']; ?></span>
                            </h3>
                            <div class="intro" title="<?php echo $rows['introduce']; ?>"><?php echo $rows['introduce']; ?></div>
                        </a>
                    </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
    <div class="side">
        <div class="card">
            <div class="card-head"><i class="fa fa-bar-chart fa-fw"></i>分类总TOP10</div>
            <div class="card-body">
                <div class="view-list">
                <?php foreach($site_list_rank as $index => $rs) { ?>
                    <a href="<?php echo empty($rs['alias']) ? "site-{$rs['id']}.html" : "{$rs['alias']}.html"; ?>" data-id="<?php echo $rs['id']; ?>">
                        <span class="rank"><?php echo $index + 1; ?></span>
                        <span class="icon"><img class="lazy-load" src="assets/images/loading.gif" data-src="<?php echo $rs['img']; ?>"></span>
                        <span class="name"><?php echo $rs['name']; ?></span>
                        <span class="view"><?php echo $rs['hits_total']; ?></span>
                    </a>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('./home/footer.php'); ?>

</body>
</html>