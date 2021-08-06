#二维码美化
二维码美化方案：
1 修改前景色背景色 已实现
2 用图片做前景背景，动图会更炫 已实现前景图
3 添加logo 已实现
4 码眼换成其它图案，只要保证其遮盖面积与使用深色系，
就不会影响识别，只在液化效果中更换了码眼，未单独实现更换码眼
5 放一些小动物在黑色方块上 未实现
6 黑色方块改成小圆点 已实现
7 黑色方块液化效果 已实现
##使用方法
```
$opt = new QrcodeOptions();
$opt->setForegroundColor(new RGBA(0,255,0));
$opt->setBackgroundColor(new RGBA(255,255,0));
$qrcodeBase64 = Qrcode::make('https://www.baidu.com',$opt);
```

通过设置QrcodeOptions参数可以实现多种效果
##修改前景色 背景色
`$opt->setForegroundColor(new RGBA(0,255,0));`

`$opt->setBackgroundColor(new RGBA(255,255,0));`
##添加logo
`$opt->setLogo(logourl);`
##使用图片做前景
注意：使用前景图片，会忽略前景色，背景色
就是会忽略setForegroundColor和setBackgroundColor

`$opt->setForegroundImg(Foreground::FOREGROUND_IMG_BEAUTY);`

此软件包内置了一些前景图，可以通过Foreground类常量来调用，也可以传入自己的前景图url地址。
内置的前景图在src\Foreground\ForegroundImages目录下，sample目录下与前景图同名文件是其对应的效果，可以按需选用

##圆点效果
RADIUS_LEVEL_x 用来控制圆弧半径的大小，分为十个等级，
当为RADIUS_LEVEL_10的时候，会完全变成圆点，其它的等级，
会显示圆角
`$opt->setDotRadius(QrcodeOptions::RADIUS_LEVEL_10);`

##液化效果
RADIUS_LEVEL_x，同理也是用来控制液化程度的
`$opt->setLiquidRadius(QrcodeOptions::RADIUS_LEVEL_10);`

当然，各种效果是可以组合使用的