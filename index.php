<?php 
    $pdo = new PDO('mysql:host=localhost; dbname=boke', 'root', 'root');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>首页 - 欧阳克个人博客</title>
    <meta name="keywords" content="博客,个人博客,欧阳克个人博客,PHP"/>
    <meta name="description" content="欧阳克是PHP中文网的讲师，愿意把知识分享给大家。" />
    <link rel="stylesheet" id="twentytwelve-style-css" href="static/css/index.css" type="text/css" media="all" />
    <style type="text/css" id="custom-background-css">
        body.custom-background {background-color:#e6e6e6;}
        input.btn-default:focus,input.no-border:focus {outline:none;}
        input.no-border {font-size:15px;}
    </style>
    <script type="text/javascript" src="static/js/jquery.js"></script>
    <script type="text/javascript" src="static/js/nav.js"></script>
</head>
<body class="home blog custom-background custom-font-enabled single-author">
    <div id="page" class="hfeed site">
        <header id="masthead" class="site-header" role="banner">
            <hgroup>
                <h1 class="site-title">
                    <a href="/" title="欧阳克个人博客" rel="home">欧阳克个人博客</a>
                </h1>
                <h2 class="site-description">欧阳克是PHP中文网的讲师，愿意把知识分享给大家。</h2>
            </hgroup>
            <nav id="site-navigation" class="main-navigation" role="navigation">
                <ul class="nav-menu">
                    <?php 
                        $menu = [
                            '首页',
                            '服务器',
                            'PHP',
                            '前端',
                            'Thinkphp',
                            'Layui',
                            '小程序',
                        ];
                        foreach ($menu as $key => $value) {
                            echo '<li>';
                            echo       '<a href="/index.php?">' . $value . '</a>';
                            echo '</li>';
                        }
                    ?>
                </ul>
                <ul class="nav-menu">
                    <?php 
                        $menu = [
                            '首页',
                            '服务器',
                            'PHP',
                            '前端',
                            'Thinkphp',
                            'Layui',
                            '小程序',
                        ];
                        foreach ($menu as $key => $value) {
                    ?>
                            <li>
                                <a href="/index.php?"><?php echo $value; ?></a>
                            </li>
                    <?php
                        }
                    ?>
                </ul>
                <ul class="nav-menu">
                    <li>
                        <a href="/index.php?">首页</a>
                    </li>
                    <?php 
                        $stmt = $pdo->prepare('select * from class order by sort desc');
                        $stmt->execute();
                        $menu = $stmt->fetchall();
                        foreach ($menu as $key => $value) {
                    ?>
                            <li>
                                <a href="/index.php?id=<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a>
                            </li>
                    <?php
                        }
                    ?>
                </ul>
            </nav>
        </header>
        
        <div id="main" class="wrapper">
            <div id="primary" class="site-content">
                <div id="content" role="main">
<!--                     <article>
                        <header class="entry-header">
                            <h1 class="entry-title"><a href="/details.html" title="构建Nginx和PHP镜像" rel="bookmark">构建Nginx和PHP镜像</a></h1>
                        </header>
                        <div class="entry-content">构建Nginx和PHP镜像</div>
                        <footer class="entry-meta">
                            发布于 
                            <a href="/index.php?time=2020-10-02" title="2020-10-02" rel="bookmark">
                                <time class="entry-date" datetime="2020-10-02">2020-10-02</time>
                            </a>。 属于 
                            <a href="/index.php?cate=4" title="查看 Linux中的全部文章" rel="category">Linux</a> 分类
                        </footer>
                    </article> -->
                    <?php 
                        // print_r($_GET);
                        if (!empty($_GET['id'])) {
                            $stmt = $pdo->prepare('select * from article where class_id='.$_GET['id']);
                        }elseif (!empty($_GET['s'])) {
                            $stmt = $pdo->prepare('select * from article where title like "%'.$_GET['s'].'%"');
                        }else{
                            $stmt = $pdo->prepare('select * from article');
                        }
                        $stmt->execute();
                        $data = $stmt->fetchall();
                        $stmt = $pdo->prepare('select * from class');
                        $stmt->execute();
                        $meun_data = $stmt->fetchall();
                        $tmp = [];
                        foreach ($meun_data as $value) {
                            $tmp[$value['id']] = $value['name'];
                        }
                        foreach ($data as $key => $value) {
                    ?>
                            <article>
                                <header class="entry-header">
                                    <h1 class="entry-title"><a href="/details.php?id=<?php echo $value['id']; ?>" title="<?php echo $value['title']; ?>" rel="bookmark">
                                    <?php 
                                        if (isset($value['title'])){
                                            echo $value['title'];
                                        }
                                    ?>
                                    </a></h1>
                                </header>
                                <?php
                                    if (!empty($value['img'])){
                                        if (!empty(strpos($value['img'], 'https'))){
                                            echo '<img src="'.$value['img'].'" alt="image_err">';
                                        }else{
                                            echo '<img src="admin/'.$value['img'].'" alt="image_err">';
                                        }
                                    }
                                ?>
                                <div class="entry-content">
                                <?php  
                                    if (isset($value['content'])){
                                        echo $value['content'];
                                    }
                                ?>
                                </div>
                                <!-- <img src="<?php echo $value['img'] ?>" alt="image_err"> -->
                                <footer class="entry-meta">
                                    发布于 
                                    <a href="/index.php?time=2020-10-02" title="2020-10-02" rel="bookmark">
                                        <time class="entry-date" datetime="2020-10-02"><?php echo $value['date']; ?></time>
                                    </a>。 属于 
                                    <a href="/index.php?id=<?php echo $value['class_id']; ?>" title="查看 Linux中的全部文章" rel="category">
                                        <?php 
                                            if (!empty($value['class_id'])) {
                                                echo $tmp[$value['class_id']];
                                            }
                                        ?></a> 分类
                                </footer>
                            </article>
                    <?php        
                        }
                    ?>
                </div>
                <div class="page">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; 上一页">
                                <span class="page-link" aria-hidden="true">&lsaquo;</span>
                            </li>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/index.php?page=2">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/index.php?page=2" rel="next" aria-label="下一页 &raquo;">&rsaquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <div id="secondary" class="widget-area" role="complementary">
                <aside id="search-2" class="widget widget_search">
                    <form role="search" id="searchform" action="" method="POST">
                        <div>
                            <label class="screen-reader-text" for="s">搜索：</label>
                            <input placeholder="搜索" type="text" class="no-border" name="keywords" id="s"/>
                            <input type="submit" class="btn btn-default" id="searchsubmit" value="搜索" />
                        </div>
                    </form>
                    
                    <script type="text/javascript">
                        $(function (){
                            $("#searchsubmit").click(function (){
                                if($("#s").val() != '') {
                                    location.href = "/index.php?s="+$("#s").val();
                                }
                                return false;
                            });
                        });
                    </script>
                </aside>
                
                <aside id="recent-posts-2" class="widget widget_recent_entries">
                    <h3 class="widget-title">热门文章</h3>
                    <ul>
                        <li>
                            <font style="color:#7a7a7a;">[0]</font>&nbsp;
                            <a href="/details.php?id=20" title="构建Nginx和PHP镜像">构建Nginx和PHP镜像</a>
                        </li>
                        <li>
                            <font style="color:#7a7a7a;">[1]</font>&nbsp;
                            <a href="/details.php?id=10" title="Mysql 触发器基础">Mysql 触发器基础</a>
                        </li>
                    </ul>
                </aside>
                
                <aside class="widget widget_recent_entries">
                    <h3 class="widget-title">最近更新</h3>
                    <ul>
                        <li>
                            <font style="color:#7a7a7a;">[0]</font>&nbsp;
                            <a href="/details.php?id=20" title="构建Nginx和PHP镜像">构建Nginx和PHP镜像</a>
                        </li>
                        <li>
                            <font style="color:#7a7a7a;">[1]</font>&nbsp;
                            <a href="/details.php?id=10" title="PHP常见的魔术常量">PHP常见的魔术常量</a>
                        </li>
                    </ul>
                </aside>
                
                <aside id="archives-2" class="widget widget_archive">
                    <h3 class="widget-title">文章归档</h3>
                    <ul>
                        <li><a href="/index.php?time=2020-10" title="2020-10">2020年10月</a>&nbsp;<font style="color:#7a7a7a;">(1)</font></li>
                        <li><a href="/index.php?time=2020-09" title="2020-09">2020年09月</a>&nbsp;<font style="color:#7a7a7a;">(4)</font></li>
                        <li><a href="/index.php?time=2020-08" title="2020-08">2020年08月</a>&nbsp;<font style="color:#7a7a7a;">(2)</font></li>
                        <li><a href="/index.php?time=2020-07" title="2020-07">2020年07月</a>&nbsp;<font style="color:#7a7a7a;">(1)</font></li>
                        <li><a href="/index.php?time=2020-06" title="2020-06">2020年06月</a>&nbsp;<font style="color:#7a7a7a;">(2)</font></li>
                        <li><a href="/index.php?time=2020-05" title="2020-05">2020年05月</a>&nbsp;<font style="color:#7a7a7a;">(1)</font></li>
                        <li><a href="/index.php?time=2020-04" title="2020-04">2020年04月</a>&nbsp;<font style="color:#7a7a7a;">(1)</font></li>
                        <li><a href="/index.php?time=2020-03" title="2020-03">2020年03月</a>&nbsp;<font style="color:#7a7a7a;">(3)</font></li>
                        <li><a href="/index.php?time=2020-02" title="2020-02">2020年02月</a>&nbsp;<font style="color:#7a7a7a;">(3)</font></li>
                        <li><a href="/index.php?time=2020-01" title="2020-01">2020年01月</a>&nbsp;<font style="color:#7a7a7a;">(2)</font></li>
                    </ul>
                </aside>
            </div>
        </div>
    
        <footer id="colophon" role="contentinfo">
            <div class="site-info">
                <span>友情链接：</span>
                    <a href="https://www.php.cn" target="_blank">PHP中文网</a>
                </div>
        </footer>
        
        <footer role="contentinfo" style="margin-top:0;">
            <div class="site-info" style="text-align:center;">
                <span>
                    <a href="https://beian.miit.gov.cn" target="_blank">苏ICP备2020058653号-1</a>
                </span>
            </div>
        </footer>
    </div>
</body>
</html>