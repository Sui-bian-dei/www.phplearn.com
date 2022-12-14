<?php 
    // print_r($_COOKIE);
    $page = 5;
    if (empty($_COOKIE)) {
        echo '<script>window.alert("请先登录");window.location.href="login.php";</script>';
        return false;
    }
    $pdo = new PDO('mysql:host=localhost; dbname=boke', 'root', 'root');
    # 统计文章数量
    $stmt = $pdo->prepare('select count(*) as count from article');
    $stmt->execute();
    $count = $stmt->fetchAll();
    $count = $count[0]['count'];
    // echo $count;
    # 计算页数
    $pages = ceil($count/$page);
    // echo $pages;
    # 获取当前页数
    if(empty($_GET['p'])){
            $p = 1;
        }else{
            $p = $_GET['p'];
    }

    # 查询数据
    $stmt = $pdo->prepare('select * from article limit '.($p-1)*$page.','.$page);
    $stmt->execute();
    $data = $stmt->fetchall();
    // print_r($data);
    $stmt_class = $pdo->prepare('select * from class');
    $stmt_class->execute();
    $data_class = $stmt_class->fetchall();
    $tmp = [];
    foreach ($data_class as $key => $value) {
        $tmp[ $value['id'] ] = $value['name'];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title>文章管理</title>
        <link rel="stylesheet" href="../static/layui/css/layui.css" />
        <link rel="stylesheet" href="../static/css/globals.css" charset="utf-8" />
        <link rel="stylesheet" href="../static/css/global.css" charset="utf-8" />
    </head>
    <body>
        <div class="layui-header header header-user" style="background-color:#24262F;"> 
            <div class="layui-container"> 
            <a class="logo" href="/">
                <img src="https://www.php.cn/static/images/logo.png" alt="layui" />
            </a> 
            <div class="layui-form component" lay-filter="LAY-site-header-component"></div> 
            <ul class="layui-nav">
                <li class="layui-nav-item fly-layui-user">
                    <a class="fly-nav-avatar">
                        <cite class="layui-hide-xs"><?php echo $_COOKIE['account']; ?></cite>
                    </a>
                </li>
                <li class="layui-nav-item fly-layui-user">
                    <a class="fly-nav-avatar">
                        <cite class="layui-hide-xs">退出</cite>
                    </a>
                </li>
            </ul> 
            </div>
        </div>
        <div class="layui-container fly-marginTop fly-user-main"> 
            <ul class="layui-nav layui-nav-tree layui-inline" style="padding: 20px 0;">
                <li class="layui-nav-item layui-this">
                    <a href="/admin/article.html">
                        <i class="layui-icon layui-icon-table"></i>文章列表
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="/admin/article_cat.html">
                        <i class="layui-icon layui-icon-tabs"></i>文章分类
                    </a>
                </li>
            </ul>
            <div class="site-mobile-shade"></div>
            <div class="fly-panel fly-panel-user" pad20="">
                <div class="layui-tab layui-tab-brief" id="LAY_uc">
                    <ul class="layui-tab-title" id="LAY_mine">
                        <li data-type="mine-jie" lay-id="index" class="layui-this">文章列表</li>
                        <button type="button" class="layui-btn" style="float:right;" onclick="add()">
                            <i class="layui-icon layui-icon-addition"></i>添加
                        </button>
                    </ul>
                    <div class="layui-tab-content" id="LAY_ucm" style="padding:5px 0;">
                        <div class="layui-tab-item layui-show">
                            <table class="layui-table" lay-skin="nob">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>标题</th>
                                        <th>添加时间</th>
                                        <th>分类</th>
                                        <th>操作</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($data as $key => $value) {
                                    ?>
                                        <tr>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['date']; ?></td>
                                        <td><?php echo $tmp[ $value['class_id'] ]; ?></td>
                                        <td>
                                            <button type="button" class="layui-btn layui-btn-normal layui-btn-xs">
                                                <i class="layui-icon layui-icon-edit"></i>
                                            </button>
                                                <button type="button" class="layui-btn layui-btn-danger layui-btn-xs">
                                                    <i class="layui-icon layui-icon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php 
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body">
                            <div class="layui-box layui-laypage layui-laypage-default">
                                <?php
                                    for ($i=1; $i <= $pages; $i++) { 
                                        if ($i == $p) {
                                ?>             
                                            <span class="layui-laypage-curr">
                                                <em class="layui-laypage-em"></em>
                                                <em><?php echo $i; ?></em>
                                            </span>
                                <?php 
                                        }else{
                                ?>
                                            <a href="article.php?p=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php
                                        }
                                    } 
                                ?>
                                
                                
                            </div>
                            <!-- <div id="demo1"></div> -->
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <script src="/static/layui/layui.js"></script>
        <script type="text/javascript">
            layui.use(['laypage','layer'],function(){
                laypage = layui.laypage
                ,layer = layui.layer;
                laypage.render({
                    elem: 'demo1'
                    ,count: 70
                });
            })
            function add(){
                window.location.href='/admin/article_add.php';
            }
        </script>
    </body>
</html>