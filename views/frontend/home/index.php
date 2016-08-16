<?php
use yii\helpers\Html;
use yii\cms\widgets\Banner;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'Home');
?>

<!-- begin x-carousel -->
<?= Banner::widget([
	'bannerId' => 'carouselHomeMain',
	'options' => ['class' => 'x-carousel J-x-carousel'],
	'backgroundImage' => true,
]) ?>
<!-- end x-carousel -->

<!-- begin x-notice -->
<div class="x-notice">
	<div class="container">
		<p>公告: 请8月1日提交检测的来我司取报告; 公告: 请8月1日提交检测的来我司取报告; 公告: 请8月1日提交检测的来我司取报告; 公告: 请8月1日提交检测的来我司取报告; 公告: 请8月1日提交检测的来我司取报告</p>
	</div>
</div>
<!-- end x-notice -->

<!-- begin x-news -->
<div class="x-news">
	<div class="container">
		<div class="row">
			<h3>最新动态</h3>
			<ul>
				<li>
					<a href="javascript:;">
						<b><img src="http://upload.cankaoxiaoxi.com/2016/0815/1471261279475.jpg" /><strong><em>2016</em><span>8-25</span></strong></b>
						<h5>新华社北京8月15日电 外交部发言人陆慷15日</h5>
						<p>宣布：二十国集团领导人第十一次峰会将于9月4日至5日在浙江杭州举行。峰会主题为“构建创新、活力、联动、包容的世界经济”。二十国集团成员和嘉宾国领导人及有关国际组织负责人将应邀与会。中国国家主席习近平将出席并主持会议，并出席金砖国家领导人非正式会晤等有关活动。</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<b><img src="http://upload.cankaoxiaoxi.com/2016/0815/1471261279516.jpg" /><strong><em>2016</em><span>8-25</span></strong></b>
						<h5>二十国集团工商峰会将于9月3日至4日在浙江杭州举行。中国国家</h5>
						<p>主席习近平将出席开幕式并发表主旨演讲。部分二十国集团成员和嘉宾国领导人及有关国际组织负责人将应邀与会。</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<b><img src="http://upload.cankaoxiaoxi.com/2016/0815/1471261279229.jpg" /><strong><em>2016</em><span>8-25</span></strong></b>
						<h5>今年1月看到的舰艏可能属于10号舰，而后来看到的那些</h5>
						<p>组件属于一个新的舰体。若有13号舰体，那将表明中国打算除了以前预估的12艘以外继续建造052D型驱逐舰。</p>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- end x-news -->

<div class="container">
	<!-- begin rolling -->
	<div class="x-rolling J-x-rolling" data-seamless="1">
		<h3>项目展示<span>Projects</span></h3>
		<div class="rolling">
			<div class="frame">
				<div class="roller">
					<ul>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
						<li><b><?= Html::a(Html::img('http://www.gxjzjc.com/imageRepository/1d505ec7-aea0-4aa7-9062-71562302f98f.jpg'), 'javascript:;', ['target' => '_blank']) ?></b></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- end x-rolling -->
</div>
