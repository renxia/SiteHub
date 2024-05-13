<?php
require('./includes/common.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;
$alias = isset($_GET['alias']) ? $_GET['alias'] : null;
if (empty($id) && empty($alias)) {
    exit('<script type="text/javascript">window.location.href="../404.html";</script>');
};

if (empty($alias)) {
    $cate_item = $DB->find('category', '*', array('id' => $id));
} else {
    $cate_item = $DB->find('category', '*', array('alias' => $alias));
}
if (empty($cate_item)) {
    exit('<script type="text/javascript">window.location.href="404.html";</script>');
};

require('./includes/lang.class.php');
$site_list = $DB->findAll('site', '*', array('catename' => $cate_item['catename']), 'lid asc');
$cate_list = $DB->findAll('category', '*', '', 'sid asc');
$site_list_rank = $DB->findAll('site', '*', null, 'hits_total desc', 10);
$page_title = $cate_item['catename'] . '- 分类列表 - ' . $conf['title'];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title><?php echo $page_title; ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords']; ?>">
    <meta name="description" content="<?php echo $conf['description']; ?>">
    <link rel="shortcut icon" type="images/x-icon" href="<?php echo $site_url; ?>/favicon.ico" />
    <link href="./assets/fontawesome/4.7.0/css/fontawesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>/assets/css/ozui.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>/templates/<?php echo $conf['theme']; ?>/css/style.css?v=<?php echo $conf['themeVersion']; ?>" />
    <?php echo $conf['script_header']; ?>

</head>

<body>
<?php require('./home/header.php'); ?>
<?php require('./home/banner.php'); ?>
<ul class="category">
    <li><a href="./"><span>返回首页</span> <i class="fa fa-reply fa-fw"></i></a></li>
<?php foreach($cate_list as $row) { ?>
    <li><a href="category-<?php echo $row['id'];?>.html" class="<?php if ($cate_item['catename'] == $row['catename']) { echo "active"; }; ?>"><span><?php echo $row['catename'];?></span> <i class="fa <?php echo $row['icon'];?> fa-fw"></i></a></li>
<?php } ?>
</ul>

<div class="container">
    <div class="main">
        <div class="card board">
            <span class="icon"><i class="fa fa-map-signs fa-fw"></i></span>
            <a href="./">导航首页</a>&nbsp;»&nbsp;<span><?php echo $cate_item['catename']; ?></span>
        </div>
        <div id="<?php echo $cate_item['catename']; ?>" class="card link-card">
            <div class="card-head">
                <i class="fa <?php echo $cate_item['icon']; ?> fa-fw"></i><?php echo $cate_item['catename']; ?>
            </div>
            <div class="card-body flex">
                <?php foreach($site_list as $rows) { ?>
                    <div class="item">
                        <a class="link-box" href="<?php echo "site-{$rows['id']}.html"; ?>" target="_blank" title="<?php echo $rows['name']; ?>" data-id="<?php echo $rows['id']; ?>">
                            <h3 class="item-title">
                                <span class="icon"><img class="lazy-load" src="assets/images/loading.gif" data-src="<?php echo $rows['img']; ?>"></span>
                                <span class="name"><?php echo $rows['name']; ?></span>
                            </h3>
                            <div class="intro" title="<?php echo $rows['introduce']; ?>"><?php echo $rows['introduce']; ?></div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="side">
        <div class="card">
            <div class="card-head"><i class="fa fa-bar-chart fa-fw"></i>分类总TOP10</div>
            <div class="card-body">
                <div class="view-list">
                <?php foreach($site_list_rank as $index => $rs) { ?>
                    <a
                        href="<?php echo empty($rs['alias']) ? "site-{$rs['id']}.html" : "{$rs['alias']}.html"; ?>"
                        data-id="<?php echo $rs['id']; ?>"
                    >
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