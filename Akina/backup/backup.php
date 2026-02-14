/** */ header **/

<?php
/**
 * Akina For Typecho移植于WordPress的Akina模板，原作者为 Fuzzz 
 * 
 * @package Akina For Typecho
 * @author 子虚之人
 * @version 4.1.3
 * @link https://zhebk.cn/
 */
 if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
// 文章置顶
if($this->options->sticky){
	$sticky = $this->options->sticky; //置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔
	if($sticky && $this->is('index') || $this->is('front')){
    $sticky_cids = explode(',', strtr($sticky, ' ', ','));//分割文本 
    $sticky_html = "<span style='color:#ff6d6d;font-weight:600'>[置顶] </span>"; //置顶标题的 html css
    $db = Typecho_Db::get();
    $pageSize = $this->options->pageSize;
    $select1 = $this->select()->where('type = ?', 'post');
    $select2 = $this->select()->where('type = ? AND status = ? AND created < ?', 'post','publish',time());
    //清空原有文章的列队
    $this->row = [];
    $this->stack = [];
    $this->length = 0;
    $order = '';
    foreach($sticky_cids as $i => $cid) {
      if($i == 0) $select1->where('cid = ?', $cid);
      else $select1->orWhere('cid = ?', $cid);
      $order .= " when $cid then $i";
      $select2->where('table.contents.cid != ?', $cid); //避免重复
    }
    if ($order) $select1->order('', "(case cid$order end)"); //置顶文章的顺序 按 $sticky 中 文章ID顺序
    if ($this->_currentPage == 1) foreach($db->fetchAll($select1) as $sticky_post){ //首页第一页才显示
      $sticky_post['sticky'] = $sticky_html;
      $this->push($sticky_post); //压入列队
    }
    $uid = $this->user->uid; //登录时，显示用户各自的私密文章
    if($uid) $select2->orWhere('authorId = ? AND status = ?',$uid,'private');
    $sticky_posts = $db->fetchAll($select2->order('table.contents.created', Typecho_Db::SORT_DESC)->page($this->_currentPage, $this->parameter->pageSize));
    foreach($sticky_posts as $sticky_post) $this->push($sticky_post); //压入列队
    $this->setTotal($this->getTotal()-count($sticky_cids)); //置顶文章不计算在所有文章内
	}
}
?>
<!-- 判断是否搜索 -->
<?php if(!$this->is('index') && !$this->is('front')): ?>
  <!-- 透明导航栏后调整间距 -->
  <?php if (!empty($this->options->menu) && in_array('transparent', $this->options->menu) ): ?>
  <style>
    .site-main {
      padding: 160px 0 0;
    }
    @media (max-width: 860px){
      .site-main {
      padding: 80px 0 0;
    }
    }
  </style>
  <?php endif ?>
	<div class="blank"></div>
	<div class="headertop"></div>
	<div class=""></div>
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<!-- 判断搜索是否有结果-是 -->	
				<?php if ($this->have()): ?>
					<header class="page-header">
						<h1 class="page-title">搜索结果: <span><?php $this->archiveTitle(array('category'=>_t('分类“%s”下的文章'),'search'=>_t('包含关键字“%s”的文章'),'tag' =>_t('标签“%s”下的文章'),'author'=>_t('%s 的主页')), '', ''); ?></span></h1>
						<span><?php echo '找到'.$this->getTotal().'篇';?></span>
					</header>
				<!-- 判断搜索是否有结果-否 -->	
				<?php else: ?>
					<header class="page-header">
						<h1 class="page-title">搜索结果: <span><?php $this->archiveTitle(array('category'=>_t('分类“%s”下暂无文章'),'search'=>_t('暂无包含关键字“%s”的文章'),'tag' =>_t('标签“%s”下暂无文章'),'author'=>_t('%s 的主页')), '', ''); ?></span></h1>
					</header>
					<div class="page-content">
						<div class="sorry">
							<p>抱歉, 没有找到你想要的文章. 看看其他文章吧.</p>
							<ul class="search-no-reasults"><?php getRandomPosts('5');?></ul>
						</div>
					</div>
				<?php endif; ?>
<!-- 不是搜索显示主页 -->
<?php else: ?>
	<div class="blank"></div>
		<div class="headertop">
			<!-- 首页大图 -->
			<div id="centerbg" style="background-image: url(<?php echo authorProfile($this->options->headimg,theurl);?>);">
				<!-- 左右倾斜 -->
				<div class="slant-left"></div>
				<div class="slant-right"></div>
				<!-- 博主信息 -->
				<div class="focusinfo">
					<!-- 头像 -->
					<div class="header-tou" >
					<a href="<?php $this->options ->siteUrl(); ?>"><img src="<?php echo theprofile ?>"></a>
					</div>
					<!-- 简介 -->
					<div class="header-info">
					<p><?php $this->options->headerinfo() ?></p>
					</div>
					<!-- 社交信息 -->
					<ul class="top-social">
						<?php
							//微博
							if ($this->options->SINA){
								echo '<li><a href="'.$this->options->SINA.'" target="_blank" rel="nofollow" class="social-sina"><img src="'.theurl.'images/sina.png"/></a></li>';
							}
							//微信
							if ($this->options->Wechat){
								echo '<li class="qq"><img style="cursor: pointer" src="'.theurl.'images/wechat.png"/></a><div class="qqInner">'.$this->options->Wechat.'</div></li>';
							}
							//QQ
							if ($this->options->QQnum){
								echo '<li class="qq"><a href="http://wpa.qq.com/msgrd?v=3&uin='.$this->options->QQnum.'&site=qq&menu=yes" target="_blank" rel="nofollow" ><img src="'.theurl.'images/qq.png"/></a>
										<div class="qqInner">'.$this->options->QQnum.'</div>
									</li>';
							}
							//酷安
							if ($this->options->coolapk){
								echo '<li class="qq"><a href="'.$this->options->coolapkLink.'" target="_blank" rel="nofollow" ><img src="'.theurl.'images/coolapk.png"/></a>
										<div class="qqInner">'.$this->options->coolapk.'</div>
									</li>';
							}
							//QQ空间
							if ($this->options->Qzone){
								echo '<li><a href="'.$this->options->Qzone.'" target="_blank" rel="nofollow" class="social-qzone"><img src="'.theurl.'images/qzone.png"/></a></li>';
							}
							//Github
							if ($this->options->Github){
								echo '<li><a href="'.$this->options->Github.'" target="_blank" rel="nofollow" class="social-github"><img src="'.theurl.'images/github.png"/></a></li>';
							}
							//Bilibili
							if ($this->options->Bilibili){
								echo '<li><a href="'.$this->options->Bilibili.'" target="_blank" rel="nofollow" class="social-bilibili"><img src="'.theurl.'images/bilibili.png"/></a></li>';
							}
							//网易云音乐
							if ($this->options->Music){
								echo '<li><a href="https://music.163.com/#/user/home?id='.$this->options->Music.'" target="_blank" rel="nofollow" class="social-bilibili"><img src="'.theurl.'images/music.png"/></a></li>';
							}
						?>
					<ul>
				</div>
			</div>
			<!-- 首页大图结束 -->
		</div>
	<div class=""></div>
	<div id="content" class="site-content">
	<!-- 顶部公告内容 -->
	<div class="notice">
		<i class="iconfont">&#xe607;</i>
			<div class="notice-content">
			<?php $this->options->NOTICE();?>
			</div>
	</div>
	<!-- 聚焦内容 -->
	<div class="top-feature">
		<h1 class="fes-title">聚焦</h1>
			<ul class="feature-content">
			<?php
			    // 默认数据
				$defaultUrl = ['https://zhebk.cn/Web/Akina.html','https://zhebk.cn/Web/userAkina.html','https://zhebk.cn/archives.html'];
				$defaultTitle = ['Akina','使用说明','文章归档'];
			    // 整理
				$featureCid = array_filter(explode(',', strtr($this->options->featureCids, ' ', ',')));
				// 循环输出
				for($i=0;$i<count($featureCid);$i++){
				    $featureNum = $i + 1;
					$this->widget('Widget_Archive@lunbo'.$i, 'pageSize=1&type=single', 'cid='.$featureCid[$i])->to($ji);
                    if ($ji->fields->thumbnail){
						$featureImg = $ji->fields->thumbnail;
					} else {
						$featureImg = theurl.'images/postbg/'.$featureNum.'.jpg';
					}
					echo '<li class="feature-'.$featureNum.'"><a href="'.$ji->permalink.'"><div class="feature-title"><span class="foverlay">'.$ji->title.'</span></div><img src="'.$featureImg.'"></a></li>';
					if( $featureNum == 3 ) {
					    break;
					}
				}
				for($i = count($featureCid); $i < 3; $i++) {
				    $addNum = $i + 1;
					echo '<li class="feature-'.$addNum.'"><a href="'.$defaultUrl[$i].'"><div class="feature-title"><span class="foverlay">'.$defaultTitle[$i].'</span></div><img src="'.theurl.'/images/feature/feature'.$addNum.'.jpg"></a></li>';
				}
			?>
			</ul>
	</div>
	<!-- 主页内容 -->
	<div id="primary" class="content-area">
		<main id="main" class="site-main indexMain" role="main">
		<h1 class="main-title">近况</h1>
<!-- 结束搜索判断 -->
<?php endif; ?>
		<!-- 开始文章循环输出 -->
    <?php $deuIndex = 1; ?>
		<?php while($this->next()): ?>
		<article class="post post-list" itemscope="" itemtype="http://schema.org/BlogPosting">
		<!-- 判断文章输出样式 -->
		<?php if ($this->fields->dtMode): ?>
		<div class="post-status">
			<div class="postava">
				<a href="<?php $this->permalink() ?>"><img alt="avatar" src="<?php echo theprofile ?>" srcset="<?php echo theprofile ?> 2x" class="avatar avatar-64 photo" height="64" width="64"></a>
			</div>
			<div class="s-content">
				<a href="<?php $this->permalink() ?>">
				<p><?php $this->excerpt(70, '...'); ?></p>
				<div class="s-time"><i class="iconfont">&#xe604;</i><?php $this->date('Y-n-j'); ?><?php if(Postviews($this)>=2000) echo"<i class='iconfont hotpost' style='margin-left: 5px;'>&#xe618;</i>" ?>
</div>
				</a>
			</div>
			<footer class="entry-footer">
		<?php else: ?>
			<div class="post-entry">
				<div class="feature">
					<a href="<?php $this->permalink() ?>"><div class="overlay"><i class="iconfont">&#xe61e;</i></div>
            <img src="<?php 
              if(array_key_exists('icon',unserialize($this->___fields())) & $this->fields->icon != null) {
                $this->fields->icon();
                } else {
                  if ($deuIndex > 7) {$deuIndex = 1;}
                  echo theurl.'images/random/deu'.$deuIndex++.'.jpg';
                }
            ?>">
          </a>
				</div>
				<h1 class="entry-title"><a href="<?php $this->permalink() ?>"><?php $this->sticky(); $this->title() ?></a></h1>
				<div class="p-time">
				<i class="iconfont">&#xe604;</i> <?php $this->date('Y-n-j'); ?><?php if(Postviews($this)>=2000) echo"<i class='iconfont hotpost' style='margin-left: 5px;'>&#xe618;</i>" ?>
				</div>
				<a href="<?php $this->permalink() ?>"><p><?php $this->excerpt(70, '...'); ?></p></a>
				<!-- 文章下碎碎念 -->
				<footer class="entry-footer">
					<div class="post-more">
							<a href="<?php $this->permalink() ?>"><i class="iconfont">&#xe61c;</i></a>
					</div>
		<?php endif; ?>
					<div class="info-meta">
						<div class="comnum">
							<span><i class="iconfont">&#xe610;</i><a href="<?php $this->permalink() ?>"><?php $this->commentsNum(_t('NOTHING'), _t('1条评论'), _t('%d条评论')); ?></a></span>
						</div>
						<div class="views">
							<span><i class="iconfont">&#xe614;</i><?php echo Postviews($this)>=10000 ? round(Postviews($this)/10000,1) .'万' : Postviews($this);?> 热度</span>
						</div>
					</div>
				</footer>
			</div>
				<hr>
		</article>
		<?php endwhile; ?>
		<!-- 结束文章循环输出 -->
		<!-- 翻页按钮 -->
		<nav class="navigator">
			<?php $this->pageLink('<i class="iconfont">&#xe611;</i>'); ?>	
			<i class="navnumber"><?php if($this->_currentPage>1) echo $this->_currentPage;  else echo 1;?> / <?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?></i>
			<?php $this->pageLink('<i class="iconfont">&#xe60f;</i>','next'); ?>
		</nav>
	</main>
	<div id="pagination"><?php $this->pageLink('加载更多','next'); ?></div>
</div>
<!-- https://cdn.jsdelivr.net/npm/sakana-widget@2.3.2/lib/sakana.min.js -->
<!-- https://cdnjs.cloudflare.com/ajax/libs/sakana-widget/2.3.2/sakana.min.js -->
<div id="sakana-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 999;"></div>
<script>
  function initSakanaWidget() {
    new SakanaWidget().mount('#sakana-widget');
  }
</script>
<script
  async
  onload="initSakanaWidget()"
  src="https://cdn.jsdelivr.net/npm/sakana-widget@2.3.2/lib/sakana.min.js"
></script>
</div>

<!-- 结束主页内容 -->
</div>
</section>
<!-- 页底信息 -->
<?php $this->need('footer.php'); ?>

/** links **/
<?php
/**
 * links
 *
 * @package custom
 */
  $this->need('header.php'); 
?>
<!-- 友链部分 -->
<div class="blank"></div>
<div class="headertop"></div>
<?php 
    $bgImgUrl = '';
    if ( $this->fields->radioPostImg != 'none' && $this->fields->radioPostImg != null ) {
        switch ( $this->fields->radioPostImg ) {
        case 'custom':
            $bgImgUrl = $this->fields->thumbnail;
            break;
        case 'random':
            $bgImgUrl = theurl.'images/postbg/'.mt_rand(1,3).'.jpg';
            break;
        }
        echo('
            <div class="pattern-center">
                <div class="pattern-attachment-img" style="background-image: url('.$bgImgUrl.')"></div>
                    <header class="pattern-header">
                <h1 class="entry-title">'.$this->title.'</h1>
            </header>
            </div>
        ');
    } else {
        echo('<style> @media (max-width: 860px){#content {margin-top: 30px;}} </style>');
    }
?>
<!-- 透明导航栏后调整间距 -->
<!-- 透明导航栏后调整间距 -->
<?php if (strlen($bgImgUrl) <= 4 && !empty($this->options->menu) && in_array('transparent', $this->options->menu) ): ?>
<style>
  .site-content {
    padding: 80px 0 0;
  }
  @media (max-width: 860px){
    .site-content {
    padding: 50px 0 0;
  }
  }
</style>
<?php endif ?>
<div id="content" class="site-content">
	<span class="linkss-title"><?php $this->title() ?></span>
	<article class="hentry">
		<div class="entry-content">
		  <?php if( !$this->content && !class_exists('Links_Plugin')) {
			  echo'
				<div class="nodata">
				    <img src="https://blog.zixu.site/usr/themes/Akina/images/warn.png">
				    <div class="nodataText">
					    <p>没有相关的数据！</p>
					    <p>请在后台编写友链html或者安装<a href="https://github.com/Zisbusy/Akina-for-Typecho/tree/master/%E5%8F%AF%E9%80%89%E6%8F%92%E4%BB%B6" target="_blank" rel="nofollow noopener noreferrer">插件</a>
					    </p>
				    </div>
				</div>
			  ';
			} else {
				$pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
				$replacement = '<a href="$1" alt="'.$this->title.'" title="点击放大图片"><img class="aligncenter" src="$1" title="'.$this->title.'"></a></div>';
				echo preg_replace($pattern, $replacement, $this->content);
				if(class_exists('Links_Plugin')){
            echo '
            <br>
            <div class="links">
              <ul class="link-items fontSmooth">
            ';
				    $rules ='
            <li class="link-item">
              <a class="link-item-inner effect-apollo" href="{url}" title="{name}" target="_blank" >
                <span class="sitename">{name}</span>
                <div class="linkdes">{title}</div>
              </a>
            </li>';
					 Links_Plugin::output($pattern=$rules, $links_num=0, $sort=NULL);
           echo '
           </div>
            </ul>
           ';
				};
			}?>
		</div>
	</article>
</div>
</div>
</section>
<?php $this->need('footer.php'); ?>


/** pages **/
<?php
/**
 * page
 *
 * @package custom
 */
  $this->need('header.php'); 
?>
<div class="blank"></div>
<div class="headertop"></div>
<?php 
    $bgImgUrl = '';
    if ( $this->fields->radioPostImg != 'none' && $this->fields->radioPostImg != null ) {
        switch ( $this->fields->radioPostImg ) {
        case 'custom':
            $bgImgUrl = $this->fields->thumbnail;
            break;
        case 'random':
            $bgImgUrl = theurl.'images/postbg/'.mt_rand(1,3).'.jpg';
            break;
        }
        echo('
            <div class="pattern-center">
                <div class="pattern-attachment-img" style="background-image: url('.$bgImgUrl.')"></div>
                    <header class="pattern-header">
                <h1 class="entry-title">'.$this->title.'</h1>
            </header>
            </div>
            <style> @media (max-width: 860px){.site-main {padding-top: 30px;}} </style>
        ');
    }
?>
<!-- 透明导航栏后调整间距 -->
<?php if (strlen($bgImgUrl) <= 4 && !empty($this->options->menu) && in_array('transparent', $this->options->menu) ): ?>
<style>
  .site-main {
    padding: 160px 0 0;
  }
  @media (max-width: 860px){
    .site-main {
    padding: 80px 0 0;
  }
  }
</style>
<?php endif ?>
<div id="content" class="site-content">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article  class="hentry">
				<header class="entry-header">
					<h1 class="entry-title"><?php $this->title() ?></h1>
				</header>
				<div class="entry-content">
					<?php
						$pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
						$replacement = '<a href="$1" alt="'.$this->title.'" title="点击放大图片"><img class="aligncenter" src="$1" title="'.$this->title.'"></a>';
						echo preg_replace($pattern, $replacement, $this->content);
					?>
				</div>
			</article>
		</main>
	</div>
</div>
<?php $this->need('comments.php'); ?>
</div>
</section>
<?php $this->need('footer.php'); ?>

/** post **/
<?php $this->need('header.php'); ?>
<!-- 文章部分 -->
<div class="blank"></div>
<div class="headertop"></div>
<style type="text/css">.site-content {padding-top:0px !important}</style>
<?php if($this->hidden): ?>
<!-- 判断文章是否加密 -->
<div id="content" class="site-content">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<article class="hentry">
		<!-- 加密文章输出 -->
		<div class="entry-content">
		<?php $this->content(); ?>
		</div>
<?php else: ?>
<!-- 不是加密文章 -->
<?php 
    $bgImgUrl = '';
    if ( $this->fields->radioPostImg != 'none' && $this->fields->radioPostImg != null ) {
        switch ( $this->fields->radioPostImg ) {
        case 'custom':
            $bgImgUrl = $this->fields->thumbnail;
            break;
        case 'random':
            $bgImgUrl = theurl.'images/postbg/'.mt_rand(1,3).'.jpg';
            break;
        }
        echo('
            <div class="pattern-center">
                <div class="pattern-attachment-img" style="background-image: url('.$bgImgUrl.')"></div>
                    <header class="pattern-header">
                <h1 class="entry-title">'.$this->title.'</h1>
            </header>
            </div>
        ');
    }
?>
<!-- 透明导航栏后调整间距 -->
<?php if (strlen($bgImgUrl) <= 4 && !empty($this->options->menu) && in_array('transparent', $this->options->menu) ): ?>
<style>
  .site-main {
    padding: 160px 0 0;
  }
  @media (max-width: 860px){
    .site-main {
    padding: 80px 0 0;
  }
  }
</style>
<?php endif ?>
<div id="content" class="site-content">
<?php
    // 文章目录展示以及切换
    if ( $this->options->postDoc != 'none' && $this->options->postDoc != null ) {
        getCatalog();
        if ($this->options->postDoc == 'rightDoc') {
            echo('<style>#toc-container {right: -260px;}</style>');
        } else {
            echo('<style>#toc-container {left: -260px;}</style>');
        }
    }
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<article class="hentry">
		<!-- 文章头部 -->
		<header class="entry-header">
		<!-- 标题输出 -->
		<h1 class="entry-title"><?php $this->title() ?></h1>
		<hr>
		<div class="breadcrumbs">	
			<div itemscope itemtype="http://schema.org/WebPage" id="crumbs">最后更新时间：<?php echo date('Y年m月d日' , $this->modified);?></div>
		</div>	
		</header>
		<!-- 正文输出 -->

<!-- 正文输出 -->
<style>
.entry-content {
    font-family: "Microsoft YaHei", "PingFang SC", sans-serif; /* 中文字体优先 */
    font-size: 16px;
    line-height: 1.8;
    color: #222;
}
</style>
<div class="entry-content">


		<?php
		    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
		    $replacement = '<a href="$1" alt="'.$this->title.'" title="点击放大图片"><img class="aligncenter" src="$1" title="'.$this->title.'"></a>';
		    echo preg_replace($pattern, $replacement, $this->content);
		?>
		</div>
		<!-- 广告展示 -->
		<?php
			if ($this->options->adPostImg){
				echo '<a href="'.$this->options->adPostkLink.'" target="_blank" rel="nofollow noopener noreferrer">
						<img style=" width: 100%; border-radius: 5px; margin: 10px 0;" src="'.$this->options->adPostImg.'">
					  </a>';
			}
		?>
		<!-- 文章底部 -->
		<footer class="post-footer">
			<!-- 阅读次数 -->
			<div class="post-like">
				<a href="javascript:;" data-action="ding" data-id="58" class="specsZan ">
					<i class="iconfont">&#xe612;</i>
					<span class="count"><?php echo Postviews($this)>=10000 ? round(Postviews($this)/10000,1) .'万' : Postviews($this);?></span>
				</a>
			</div>
			<!-- 分享按钮 -->
			<div class="post-share">
				<ul class="sharehidden">
					<li><a href="https://api.pwmqr.com/qrcode/create/?url=<?php $this->permalink(); ?>" onclick="window.open(this.href, 'renren-share', 'width=490,height=700');return false;" class="s-weixin"><img src="<?php echo theurl; ?>images/wechat.png"/></a></li>
					<li><a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php $this->permalink(); ?>&title=<?php $this->title() ?>" onclick="window.open(this.href, 'weibo-share', 'width=730,height=500');return false;" class="s-qq"><img src="<?php echo theurl; ?>images/qzone.png"/></a></li>
					<li><a href="http://service.weibo.com/share/share.php?url=<?php $this->permalink(); ?>&title=<?php $this->title() ?>" onclick="window.open(this.href, 'weibo-share', 'width=550,height=235');return false;" class="s-sina"><img src="<?php echo theurl; ?>images/sina.png"/></a></li>
				</ul>
				<i class="iconfont show-share">&#xe60c;</i>
			</div>

			<!-- 文章标签 -->
			<div class="post-tags">
				<i class="iconfont">&#xe602;</i>
				<?php if(  count($this->tags) == 0 ): ?>
					<?php $this->category('、', true, 'none'); ?>
				<?php else: ?>
					<?php $this->tags('、', true, 'none'); ?>
				<?php endif; ?>
			</div>
		</footer>
		</article>
		<!-- 版权声明 -->
		<div class="open-message">
			<p>声明：<?php $this->options->title() ?>|版权所有，违者必究|如未注明，均为原创|本网站采用<a href="https://creativecommons.org/licenses/by-nc-sa/3.0/" target="_blank">BY-NC-SA</a>协议进行授权</p>
			<p>转载：转载请注明原文链接 - <a href="<?php $this->permalink(); ?>"><?php $this->title() ?></a></p>	
		</div>
		<!-- 相邻文章 -->
		<section class="post-squares nextprev">
			<?php theNextPrev($this); ?>
		</section>
<?php endif; ?>
<!-- 判断文章加密结束 -->
		<!-- 个人信息 -->
		<section class="author-profile">
			<div class="info" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
				<div class="pf-gavtar">
					<div class="pf-tou" >
						<a><img src="<?php echo theprofile ?>"></a>
					</div>
				</div>
				<div class="meta">
					<span class="title">Author</span>
					<h3 itemprop="name">
						<a href="/" itemprop="url" rel="author"><?php $this->author(); ?></a>
					</h3>
				</div>
			</div>
			<hr>
			<p><i class="iconfont">&#xe61a;</i><?php $this->options->headerinfo() ?></p>
		</section>
		</main>
	</div>
</div>
<?php if($this->hidden): ?>
<?php else: ?>
<!--评论输出地方-->
<?php $this->need('comments.php'); ?>
<?php endif; ?>
</div>
</section>
<?php $this->need('footer.php'); ?>

/** tags **/
<?php
/**
 * tags
 *
 * @package custom
 */
  $this->need('header.php'); 
?>
<div class="blank"></div>
<div class="headertop"></div>
<?php 
    $bgImgUrl = '';
    if ( $this->fields->radioPostImg != 'none' && $this->fields->radioPostImg != null ) {
        switch ( $this->fields->radioPostImg ) {
        case 'custom':
            $bgImgUrl = $this->fields->thumbnail;
            break;
        case 'random':
            $bgImgUrl = theurl.'images/postbg/'.mt_rand(1,3).'.jpg';
            break;
        }
        echo('
            <div class="pattern-center">
                <div class="pattern-attachment-img" style="background-image: url('.$bgImgUrl.')"></div>
                    <header class="pattern-header">
                <h1 class="entry-title">'.$this->title.'</h1>
            </header>
            </div>
            <style> @media (max-width: 860px){.site-main {padding-top: 30px;}} </style>
        ');
    }
?>
<!-- 透明导航栏后调整间距 -->
<?php if (strlen($bgImgUrl) <= 4 && !empty($this->options->menu) && in_array('transparent', $this->options->menu) ): ?>
<style>
  .site-main {
    padding: 160px 0 0;
  }
  @media (max-width: 860px){
    .site-main {
    padding: 80px 0 0;
  }
  }
</style>
<?php endif ?>
<div id="content" class="site-content">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main" style="margin-bottom:50px;">
			<article  class="hentry">
      <?php echo '<embed style="max-width: 300px;margin: 0 auto 83px;display: block;" src="'.theurl.'images/tags.svg">';?>
				<header class="entry-header">
					<h1 class="entry-title"><?php $this->title() ?></h1>
				</header>
				<div class="entry-content">
					<!--编辑器内容-->
					<?php
						$pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
						$replacement = '<a href="$1" alt="'.$this->title.'" title="点击放大图片"><img class="aligncenter" src="$1" title="'.$this->title.'"></a>';
						echo preg_replace($pattern, $replacement, $this->content);
					?>
	                <!--标签云输出-->
                    <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=0')->to($tags); ?>
                    <?php if($tags->have()): ?>
                        <ul class="tags-list">
                            <?php while ($tags->next()): ?>
                                <li><a href="<?php $tags->permalink(); ?>" rel="tag" class="size-<?php $tags->split(5, 10, 20, 30); ?>" title="<?php $tags->count(); ?> 个话题"><?php $tags->name(); ?> (<?php $tags->count(); ?>)</a></li>
                            <?php endwhile; ?>
                    <?php else: ?>
                            <li><?php _e('没有任何标签'); ?></li>
                        </ul>
                    <?php endif; ?>
				</div>
			</article>
		</main>
	</div>
</div>
</div>
</section>
<?php $this->need('footer.php'); ?>
