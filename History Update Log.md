# 原README

# Akina-for-Typecho

Akina for Typecho 主题模板（项目已不再维护）

![image](https://github.com/Zisbusy/Akina-for-Typecho/blob/master/Akina-img/Akina.jpg)

## 模版特点

1. 同时采用`QQ`和`Gravatar`，来适应国内环境，QQ邮箱优先使用`QQ`头像，
2. 平滑滚动，感谢开源项目[`smoothscroll-for-websites`](https://github.com/gblazex/smoothscroll-for-websites)
3. 表情，感谢开源项目[`OwO`](https://github.com/DIYgod/OwO)
4. 支持`ajax`评论
5. 响应式设计，多端无障碍浏览

## 安装方法

将Akina文件夹放到typecho下/usr/themes，在后台启用。
打开"设置外观"填写相关信息
建议安装随主题附带的links插件，（不安装也可以写html实现友链，代码在下面）

## 更新方法

小版本：将Akina文件夹覆盖到typecho下/usr/themes。
大版本：检查后台设置项，文章关键字。

### 关于表情

主题自带一种表情包，可仿照其格式自行添加表情，但是注意本主题仅且只能使用图标包，即“img”标签，

### 主页home设置

![image](https://github.com/Zisbusy/Akina-for-Typecho/blob/master/Akina-img/Akina-home.png)

Akina 提供了一个独特的首页页面  
在博客后台-设置-阅读-站点首页  
选择直接调用 `hmoe.php`模板文件，并勾选 同时将文章列表页路径更改为`/blog`（当然可以改成其他的，但要同时修改模板里路径`home.php`）  

### 其他页面

在管理-独立页面-新增页面中  
友链建议为`links.html`结尾。  
关于建议为`about.html`结尾。  
标签云建议为`tags.html`结尾。  
留言建议为`message.html`结尾。  
归档建议为`archives.html`结尾。  
自定义模板选择名字相同模板（如果没有选择page），建议请提前[配置好伪静态](https://www.typechodev.com/theme/478.html)。

### 友链写法

安装links插件后不需要写html了

```html
!!!
<br/>
<div class="links">
    <ul class="link-items fontSmooth">
        <li class="link-item"><a class="link-item-inner effect-apollo" href="http://zhebk.cn/" title="我们，渺小到不可一世。" target="_blank" ><span class="sitename">纸盒博客</span><div class="linkdes">我们，渺小到不可一世。</div></a></li>
        ......
    </ul>
</div>
!!!
```

### 画廊图片写法

已经使用正则替换自动化，不需要写了。

```html
!!!
<a href="大图片地址" alt="说明" title="标题"><img class="aligncenter" src="小图片地址" alt="说明"></a>
!!!
```

### 下载按钮写法

```html
!!!
<p>
<a id="download_link" class="download" href="下载url" rel="external" target="_blank" title="下载地址">  
<span><i class="iconfont icon-download"></i>点击下载</span>
</a>
</p>
!!!
```

### 文章特殊标签样式

![image](https://github.com/Zisbusy/Akina-for-Typecho/blob/master/Akina-img/h2-h5.jpg)

### CDN镜像加速

请在CDN服务商配置加速域名后在后台模板设置按提示填写域名即可。
如图标出现错误后请根据CDN服务商提示来解决跨域问题，
注：七牛云没有设置选项，请提交工单。将CDN响应头设置成 Access-Control-Allow-Origin: *
2021-08-01:似乎已经可以在七牛后台直接设置了。  

镜像加速地址同源站地址如:
<https://zhebk.cn/usr/themes/Akina/images/favicon.ico>
<https://cdn.zhebk.cn/usr/themes/Akina/images/favicon.ico>

提示：劣质CDN甚至会拖慢网站的速度
CDN付费用户注意，请做好防盗链，不当操作会让你的钱包遭受不可逆的降维打击。

### 使用技巧

1. 在文章编辑里添加自定义缩略图图片链接。可自定义页面(除了归档)的顶部图片,  默认随机使用`Akina\images\postbg`下图片。
2. 在文章编辑里可开启动态式文章展示样式。使用动态样式时，文章首页不会看见标题，默认显示文章的前`70`个字符，可使用`<!--more-->`摘要分割线自定义显示内容。  
3. 可以填写页面首页图标来改变文章列表的小图
4. 文章小火花触发条件：阅读量大于等于2000。
5. 自定义聚焦文章后 头部图获取规则 自定义缩略图>默认
6. 修改样式可以使用自定义css、js

## 演示地址

[https://www.bilibili.com/video/av68759722/](https://www.bilibili.com/video/av68759722/)

## 特别感谢

感谢[Typecho](http://docs.typecho.org/doku.php)官方文档(虽然有点简陋)  
感谢[QQ爹博客](https://qqdie.com/)，直接或者间接的帮助  
感谢[FUIDESIGN](http://fui.im/)原作[Akina](https://github.com/Xoin-Yang/Akina)(大佬的群 464877306 -永远的AKINA)  
以及[@友人C](https://www.ihewro.com/)`@WeX`[@Kit](http://www.aihack.cn/) (未艾特到的大佬请担待，记性不好，)  

# History Update Log

2.2版本之前的日志

2019-8-8--`v2.1`  
    修复搜索问题
    更新备案号地址  感谢[紫龙](https://izilong.cn/)反馈  
    优化评论数显示  
2019-7-20--`v2.0`  
    修复404页面a标签  感谢`a'ゞ`反馈  
    修复文章置顶空白时自定义主页报错  感谢`a'ゞ`、`QIZI297`反馈  
    修复home、404页面CDN加速域名的判断  
    优化显示再次评论时评论框边框  感谢`且听风吟`反馈  
2019-7-17--`v1.9`  
    规范归档页面php语法  感谢`AWEI`反馈  
    主题层面不操作垃圾评论开关  感谢`苏苏`建议  
    统一评论翻页字体  
    文章底部个人简介跟随后台设置  感谢`a'ゞ`反馈  
    优化评论提示  
2019-6-20--`v1.8`  
    某些情况下原站或者加速域名获取错误 感谢 k、荒野无灯  
    修复第一次访问文章后阅读数量不变的bug 感谢 [JIElive](https://www.offodd.com/75.html)  
    主题层面关闭反垃圾保护、启用分页、将第一页作为默认显示、将较新的的评论显示在前面。  
    主题层面评论允许img标签  
2019-6-8--`v1.7`  
    完善文章加密页面  
    修复[APlayer-Typecho](https://github.com/MoePlayer/APlayer-Typecho)和类似插件不能加载的bug  
2019-6-1--`v1.6`  
    添加“小火花”（触发条件阅读量大于等于1000）  
    添加文章置顶  
    修复readme版本号过低bug  
2019-5-24--`v1.5`  
    添加CDN镜像加速 感谢 [QQ爹博客-YoDu模板](https://qqdie.com/)  
    修复聚焦内容为空时bug  
    修复版本号过低bug  
2019-5-18 --`v1.4`  
    添加首页图自定义选项  
    调整文章头部图大小  
    其他细节调整  
2019-5-11 --`v1.3`  
    解决在php7.+版本中dt动态样式失效  
    调整加载动画 结束动画位置  
    独立页面（除了归档）添加头部图（需自定义img），并添加动画  
    提供选项，一直显示首页大图  
    优化头像显示，修改全局头像获取源为QQ头像  
2019-4-26 --`v1.2`  
    优化表情功能体验  
    修复`ajax`评论`bug`  
    更加安全的`a`标签跳转 [王叨叨](https://wangdaodao.com/20190112/prevent-sending-http-referer-headers-from-your-website.html)  
2019-4-18 --`v1.1`  
    修改一些细节问题  
    优化`ajax`评论，修复`bug`  
    优化`js`里`http/https`判断（以前的判断丢死人了）  
    调整`js`编码格式为`utf-8` 避免中文字符乱码  
    优化评论结构  
2019-4-4 --`v1.0`  
    解决首页表情 `js` 报错  
    底部添加版权信息(要求至少保留主题名称及其超链接)  
    调整 `H3` 标签字体大小和颜色  
    修改文章末尾头像以及对应链接  
    `home`页面添加备案号版权信息，优化代码，删除不必要代码  
    调整`css`编码格式为`utf-8` 避免中文字符乱码  
2019-3-31  
    回复添加 `@`  
    优化相邻文章获取显示方式  
    更新修复平滑滚动，感谢开源项目[smoothscroll-for-websites](https://github.com/gblazex/smoothscroll-for-websites)  
2019-3-24  
    评论添加表情，感谢开源项目[`OwO`](https://github.com/DIYgod/OwO) ![yes](https://zhebk.cn/usr/themes/Akina/images/smilies/alu/jizhang.png)  
2019-3-9  
    优化两处随机图获取 `php`  
    借助草料`api`实现微信分享  
2019-2-27  
    为`H2`标签添加新样式、调整文章翻页按钮间距，手机页面文章顶部图片大小  
    解决在某些手机浏览器上侧边栏头像和搜索不居中问题  
    完善文章阅读次数统计  
    添加平滑滚动 对比地址：<http://ts.zixu.site/archives/5.html>  
2019-2-12  
    优化完善`DNS`预解析  
    初步完成`ajax`评论  
2018-12-18  
    优化完善`home`页面  
    调整首页聚焦图大小解决在某些情况下图片下方出现黑线的问题  
2018-12-08  
    优化了一些js，初步支持`https` 、  
    调整了QQ和Gravatar头像获取地址。  
