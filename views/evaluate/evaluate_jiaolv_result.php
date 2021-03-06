<?php $this->display('myroom/page_header'); ?>
</head>
<style>
.lefrig {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #cdcdcd;
    float: left;
    margin-top: 15px;
    padding-bottom: 10px;
    width: 786px;
}

.redsrt {
    background: none repeat scroll 0 0 #fff;
    float: left;
    padding-bottom: 20px;
    width: 786px;
	#height:780px;
	#overflow-y:auto;
}
.hrrty {
    background: none repeat scroll 0 0 #4fcffe;
    border-bottom: 1px solid #cecece;
    color: #fff;
    font-size: 14px;
    height: 34px;
    line-height: 34px;
    padding-left: 10px;
}

.rgiege {
    display: inline;
    float: left;
    font-size: 14px;
    line-height: 1.8;
    margin: 10px 50px 0;
    text-indent: 30px;
    width: 710px;
}
.dgeod {
    display: inline;
    float: left;
    font-size: 14px;
    font-weight: bold;
    line-height: 1.8;
    margin: 10px 50px 0;
    width: 710px;
}

.fgngr {
    border-bottom: 1px solid #e3e3e3;
    display: inline;
    float: left;
    font-size: 14px;
    line-height: 1.8;
    margin: 10px 50px 0;
    padding: 10px 0;
    width: 710px;
}

</style>
<body>
<?php 
$typearray = array(
	'dongji'=>'学习动机测试',
	'xintai'=>'应考心态测评 ',
	'jiaolv'=>'焦虑心理测评 ',
	'shengxue'=>'升学择业测评 ',
)
?>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('myroom/evaluate');?>">自我测评</a> > <?=$typearray[$type]?> >测评结果
</div>
<div class="lefrig" style="margin-top:10px;">
<div class="redsrt" style="padding-bottom:20px;">
<h2 class="hrrty">焦虑心理测评结果</h2>
<p class="dgeod">测评结果：</p>
<?php if($score>=0 && $score<=24){?>
<p class="rgiege">测试获得<?=$score?>分。恭喜你，你状态很稳定，心态很好，没有焦虑心理。希望你再接再厉，继续保持，以乐观积极的态度迎接考虑，稳定发挥，考出好成绩。</p>
<p class="dgeod">专家分析：</p>
<p class="rgiege">焦虑是指一种缺乏明显客观原因的内心不安或无根据的恐惧，是人们遇到某些事情，如学生遇到难题，或者成绩不如意等困难、挑战和危险时候出现的一种正常的情绪反应。焦虑通常情况下与精神打击以及即将来临的、可能造成的威胁或危险相联系，主观表现出感到紧张、不愉快，甚至痛苦以至于难以自制，严重时会伴有植物性神经系统功能的变化或失调，如失眠等。</p>
<p class="rgiege">焦虑有状态性焦虑和质性焦虑两类。状态性焦虑是由于某一种情境而引起的焦虑，情境改变时，焦虑随之消失。但有时某种情境很特殊，产生的焦虑十分强烈，有可能产生短暂的人格变化。学生的焦虑，大多属于此类。很多人因为成绩不理想，或者家长老师的期待值过高，或者临近考试等，导致压力的产生，只要老师和家长注意引导和调整，能够很快的得到改善。特质性焦虑。由于一个人的人格特点与众不同，在相同的情境中，其情绪反应的频度和强度也与众不同。例如，在与陌生人相处的时候，有的人就会出现这种特质性焦虑。这种多出现于调班、小升初、初升高等特定时期，一般经过一段过渡时期，也能够快速的适应。</p>
<p class="rgiege">焦虑是人们对情境中的一些特殊刺激而产生的正常心理反应，只是每个人经历的时间长短不一或程度不同。只有当焦虑原因不存在或不明显，焦虑症状很突出而其他症状不突出，焦虑的持续时间及程度均超过一定的范围，以致影响正常的生活、学习、工作时，才可以认为患了焦虑症，又称为焦虑性神经症。这个时候，必须向医生寻求帮助。</p>
<p class="rgiege">你的测试结果很理想，无需担心这方面的问题，说不定还能帮助其他同学克服焦虑症呢！</p>


<?php }elseif($score>=25 && $score<=49){?>
<p class="rgiege">测试获得<?=$score?>分。你有轻度的焦虑，请注意及时调整心态，正确面对考试。</p>
<p class="dgeod">专家分析：</p>
<p class="rgiege">首先需要了解的是，考试对学生来说，是一种重大的事情。而人在压力大的时候，会出现一些身心反应，不仅心理有变化，生理上也会有变化。在心理上，容易出现躁动不安的表现。距离高考剩下的时间很短，考生会显得特别着急。急着做这做那，总觉得时间不够用，事情做不踏实，自己定的目标也达不到。在生理上的反应，考生容易感觉疲劳、烦躁，出现心跳加快，呼吸急促，出汗增多等现象。这些反应和现象是非常正常，也是非常常见的，你不必惊慌。</p>
<p class="dgeod">专家建议：</p>
<p class="rgiege">出现焦虑状况，你应该如何应对呢？</p>
<p class="rgiege">1、相信自己。在这场规模宏大的高考中，高手如云，但对手只有一个，那就是你自己。无论结果如何，只要真正付出了就无遗憾。</p>
<p class="rgiege">2、学会保持适度的紧张。心理研究发现，保持适度的心理压力有利于高考复习、备考。压力过大，会造成紧张、急躁心情；没有压力，也不利于学习效率的提高。所以，考生必须学会调节自身的心理压力。怎样保持适度的紧张呢？最关键的是：对自己的期望值符合自己的实际水平，快速利用并严格控制时间。</p>
<p class="rgiege">3、学习计划的制定要符合自己的实际水平，不能定的任务太多，应该是自己经过努力可以实现的。</p>
<p class="rgiege">4、把自己整理出来的复习要点制成录音，反复去倾听，既可以加深记忆又可以培养对学习的兴趣。</p>
<p class="rgiege">5、要在老师的指导下制定自己的复习计划，做到以“我”为主，紧而不乱，不要盲目地跟着别人跑，尽量以平静的心情来复习备考。</p>
<p class="rgiege">6、不要沉浸在着急的情绪中，行动起来！你不妨根据以下几条专家的考前复习建议去做：</p>
<p class="rgiege">第一、学习你最感兴趣的学科。</p>
<p class="rgiege">第二、烦恼时不去看书，去适当做些运动。</p>
<p class="rgiege">第三、烦恼时不做题，看基本概念。</p>
<p class="rgiege">第四、烦恼时做简单的题，不做难题。</p>
<p class="rgiege">最后，希望你能及时调整心态，保持乐观积极的态度，迎接考试。你要相信自己，只要正常发挥，就能够取得良好的成绩。</p>



<?php }elseif($score>=50 && $score<=74){?>
<p class="rgiege">测试获得<?=$score?>分。你已经有了中度焦虑心理，需要引起重视了，请告知家长，让家长和你一起努力，克服焦虑心理，积极迎接考试。</p>
<p class="dgeod">专家分析：</p>
<p class="rgiege">首先需要了解的是，考试对学生来说，是一种重大的事情。而人在压力大的时候，会出现一些身心反应，不仅心理有变化，生理上也会有变化。在心理上，容易出现躁动不安的表现。距离高考剩下的时间很短，考生会显得特别着急。急着做这做那，总觉得时间不够用，事情做不踏实，自己定的目标也达不到。在生理上的反应，考生容易感觉疲劳、烦躁，出现心跳加快，呼吸急促，出汗增多等现象。这些反应和现象是非常正常，也是非常常见的，你不必惊慌。</p>
<p class="dgeod">专家建议：</p>
<p class="rgiege">如果发现自己有中度焦虑症状，该如何应对呢？专家建议学生和家长要双管齐下，共同努力，让学生快速调整状态。</p>
<p class="dgeod">作为学生：</p>
<p class="rgiege">1、相信自己。在这场规模宏大的高考中，高手如云，但对手只有一个，那就是你自己。无论结果如何，只要真正付出了就无遗憾。</p>
<p class="rgiege">2、学会保持适度的紧张。心理研究发现，保持适度的心理压力有利于高考复习、备考。压力过大，会造成紧张、急躁心情；没有压力，也不利于学习效率的提高。所以，考生必须学会调节自身的心理压力。怎样保持适度的紧张呢？最关键的是：对自己的期望值符合自己的实际水平，快速利用并严格控制时间。</p>
<p class="rgiege">3、学习计划的制定要符合自己的实际水平，不能定的任务太多，应该是自己经过努力可以实现的。</p>
<p class="rgiege">4、把自己整理出来的复习要点制成录音，反复去倾听，既可以加深记忆又可以培养对学习的兴趣。</p>
<p class="rgiege">5、要在老师的指导下制定自己的复习计划，做到以“我”为主，紧而不乱，不要盲目地跟着别人跑，尽量以平静的心情来复习备考。</p>
<p class="rgiege">6、不要沉浸在着急的情绪中，行动起来！你不妨根据以下几条专家的考前复习建议去做：</p>
<p class="rgiege">第一、学习你最感兴趣的学科。</p>
<p class="rgiege">第二、烦恼时不去看书，去适当做些运动。</p>
<p class="rgiege">第三、烦恼时不做题，看基本概念。</p>
<p class="rgiege">第四、烦恼时做简单的题，不做难题。</p>
<p class="rgiege">最后，希望你能及时调整心态，保持乐观积极的态度，迎接考试。你要相信自己，只要正常发挥，就能够取得良好的成绩。</p>
<p class="dgeod">作为家长：</p>
<p class="rgiege">调查发现，随着高考临近，考生复习越来越紧张，有的考生出现心理焦虑，这也是正常的。可是，有些家长比考生还要焦虑。对此，心理咨询李老师认为，让孩子以放松的心态迎接高考，家长首先要以平常心对待，给孩子营造一个良好宽松的心理环境。</p>
<p class="rgiege">首先，家长尽量避免对孩子过度关注，比如每天都问孩子：“今天复习怎么样啊，有没有遇到难题啊？”这样过多的询问，可能会增加孩子不必要的压力和焦虑。</p>
<p class="rgiege">其次，家长对孩子的目前的整体现状应该有个客观的认识，不要整天强调孩子必须考多少分，必须考什么学校。家长要接受“孩子学习的状态和习惯不是一时就能扭转过来的”这个现实，以对自己的心理进行恰当的调适。</p>
<p class="rgiege">最后，不要将高考冲刺搞得跟如临大敌一般，比如在家里走路的脚步都很轻、不敢开电视……总是担心会影响孩子的备考复习。其实大可不必如此，有时候家长过于谨慎，虽然你没有在口头表达出什么，可是孩子时刻都能感受到这种如临大敌般的紧张，反而可能给孩子增加不必要的心理负担。</p>
<p class="rgiege">最后，希望学生和家长一起努力，克服考前焦虑症状，积极乐观的迎接高考，这样才能取得良好的成绩！</p>



<?php }elseif($score>=75 && $score<=99){?>
<p class="rgiege">测试获得<?=$score?>分。你已经有了重度焦虑心理，需要引起高度重视了。请告诉家长和老师，必要的时候向医生寻求帮助。这里专家讲给与一定的建议，让学生、老师和家长一起来共同努力，尽量克服焦虑心理，以良好的状态迎接考试。</p>
<p class="dgeod">专家分析：</p>
<p class="rgiege">首先需要了解的是，考试对学生来说，是一种重大的事情。而人在压力大的时候，会出现一些身心反应，不仅心理有变化，生理上也会有变化。在心理上，容易出现躁动不安的表现。距离高考剩下的时间很短，考生会显得特别着急。急着做这做那，总觉得时间不够用，事情做不踏实，自己定的目标也达不到。在生理上的反应，考生容易感觉疲劳、烦躁，出现心跳加快，呼吸急促，出汗增多等现象。这些反应和现象是非常正常，也是非常常见的，你不必惊慌。</p>
<p class="dgeod">专家建议：</p>
<p class="rgiege">如果发现自己已经有了重度焦虑症状，请及时与家长老师联系，必要时候向医生寻求帮助，在这里，专家也会给出多种的自疗方法、饮食法、失眠治疗法等，全面帮助你快速摆脱焦虑，重新恢复精神，信心迎考。</p>
<p class="rgiege">需要注意的是，焦虑症状严重者，往往伴随着失眠状况，失眠则会导致精神和身体的双重虚弱，使焦虑症更加严重，因此需要引起重视。</p>
<p class="dgeod">考前心理调适：</p>
<p class="rgiege">1、目标适当，乐观自信。自信是高考成功的基础，要乐观自信，就要将高考的目标定得适当，不要过高；不要与他人攀比，要认识到只要考出自己平时的成绩就是成功。</p>
<p class="rgiege">2、提升实力，你需要针对自己的学科情况，有针对性地进行训练；累了，就听听音乐，看看报纸，坦然休闲；学会放松，你才能更好地调动自己的能量。</p>
<p class="rgiege">3、调整好生物钟。复习期间，有同学喜欢在夜晚比较安静的情况下学习，白天睡觉。这种情况需要在考前的一个星期之前调整过来。因为高考的时间不是在夜晚，而是在白天，你可以在晚上10点睡觉，早上6点起床，逐步把自己的兴奋点调整到考试时间。</p>
<p class="rgiege">4、浏览知识。可以浏览一遍数理公式、文学常识等内容，翻一翻手边自己考过的试题，把常出错的地方再强化一下。</p>
<p class="rgiege">5、回归课本，查漏补缺。对前一阶段做题过程中发现的基础知识、基本概念的欠缺更要着重领会，对课本上重要的结论性语句要记熟。</p>
<p class="rgiege">6、回顾反思常错、易错题目。对自己前一阶段整理出的错题进行回顾，找到自己比较薄弱的知识点重点反思，找出自己常错的原因，有针对性地加强巩固。</p>
<p class="rgiege">7、不沉迷于做难题。攻克难题需要花费大量的精力和时间，如果久攻不下，一是占用了大量的宝贵时间，二是降低了自己的信心，加重了对高考的焦虑。</p>
<p class="dgeod">饮食搭配及食谱：</p>
<p class="rgiege">随着高考临近，许多家长都想给考生增加营养，却不知道如何搭配饮食。这里有中国学生营养学会促进会理事石元刚教授给广大考生开的一张食谱。</p>
<p class="rgiege">石教授认为，考前学生学习紧张，大脑疲劳睡眠不好影响食欲和身体健康，所以一定要注意膳食平衡，近期饮食不要太油腻，不要大鱼大肉，要以素菜为主。</p>
<p class="rgiege">在素菜方面，要选择新鲜的蔬菜和水果，如刚上市的桃、樱桃、草莓等，不要吃储存太久的水果。</p>
<p class="rgiege">特别注意不要吃零食，以免主餐时胃液分泌不足，消化不良。</p>
<p class="rgiege">一日三餐，早餐要吃饱、吃好，否则上午9到10时血糖下降，记忆力减退，甚至昏昏沉沉。最好有1至2个鸡蛋，用白水煮或蒸成蛋花。中午应吃得丰盛些。晚餐不宜吃得太多，否则胃大量充血，晚上学习时大脑供血不足。晚上复习功课较晚可在睡前1小时吃点牛奶、蛋糕、饼干之类充饥。</p>
<p class="dgeod">高考营养食谱：</p>
<p class="rgiege">方案一：早餐：馒头和草莓酱、牛奶(或豆奶)、煮荷包蛋1个、酱黄瓜，水果：夏橙或白萝卜1个。中餐：荞麦大米饭、香菇菜心、糖醋带鱼、豆腐血旺丝瓜汤。晚餐：绿豆粥、白菜猪肉包子、虾皮冬瓜。</p>
<p class="rgiege">方案二：早餐：玉米窝窝头、牛奶(或豆奶)、五香蛋1个、豆腐乳(1/4块)，水果：枇杷(或长生果)3-4个，中餐：花生米饭、肉末茄子、葱花土豆泥、鸭子海带汤。晚餐：苋菜稀饭、豆沙包、菜椒榨菜肉丝。</p>
<p class="rgiege">方案三：早餐：鲜肉包、牛奶(或豆奶)、咸鸭蛋(半个)、素炒三丝(莴笋、白萝卜、胡萝卜)，水果：鸭梨(或西瓜)一个。中餐：红枣米饭、黄豆烧牛肉、干煸四季豆、金针菇紫菜蛋汤。晚餐：三鲜面(猪肝、火腿肠、黑木耳、平菇)、清炒菠菜、青椒土豆丝。</p>
<p class="rgiege">方案四：早餐：苹果酱花卷、牛奶(或豆奶)、煮荷包蛋1个、炒豇豆，水果：香蕉(或黄瓜)1根。中餐：二米饭(黑米、标米)、香菇黄花黑木耳肉片、红椒炒黄瓜、白萝卜海带排骨汤。晚餐：豆浆稀饭、葱花煎饼、菜椒芹菜肉丝。</p>
<p class="rgiege">方案五：早餐：酱肉包、牛奶(或豆奶)、素炒三丝(莴笋、白萝卜、胡萝卜)、鹌鹑蛋2个，水果：猕猴桃(或桃子)1-2个。中餐：赤豆米饭、魔芋烧鸭、红椒炒花菜、鱼头香菇冬苋菜汤晚餐：芹菜猪肉包子、西红柿炒鸡蛋、肉末豆腐脑。</p>
<p class="rgiege">方案六：早餐：面包、牛奶、煎鸡蛋1个、五香豆腐干，水果：草莓(或李子)5-6个。中餐：二米饭(大米、小米)、五香耗儿鱼、五彩银丝(黄豆芽、胡萝卜、莴笋)、鸡腿菇木耳菜猪肝汤。晚餐：玉米粥、鸡蛋发糕、鱼香肉丝。</p>
<p class="dgeod">应付考前焦虑失眠：</p>
<p class="rgiege">除此之外，伴随长期焦虑心理，会出现失眠现象。有些同学在平时没有什么睡眠问题，可到了临近高考的日子却显得特别烦燥不安，寝食难安。躺在床上，翻来覆去，总是难以入眠。高考考前动员时间比较长，长时间地处在紧张与焦虑的状态中，必然会导致失眠。</p>
<p class="rgiege">那么，如何对付失眠焦虑呢？</p>
<p class="rgiege">1、适当地做些准备。如，睡前不做激烈运动，喝杯热牛奶、洗个热水澡等有助于更快地入睡。</p>
<p class="rgiege">2、不过分关注睡眠状况。有些考生因为担心自己睡不好会影响第二天的复习效果，从而过度关心自己是否一上床就能入睡，结果导致了失眠的产生。考生往往会过度夸大了失眠所产生的消极影响是失眠的真正危害所在。“一夜不睡又有何妨？闭目养神也不错。”把对失眠的担心彻底抛开，做好失眠的准备，反而会让人内心平静。</p>
<p class="rgiege">3、做一些积极想象。如果躺在床上一时睡不着，满脑子的“胡思乱想”，不要着急，告诉自己说：“没关系，我只是有点兴奋而已。”不强迫自己入睡，身心放松，闭目养神，睡意反而会不期而至。也可以做一些积极的想象，如想象自己漂在水面上，非常舒服；或者躺在软软的草地上，困极了……</p>
<p class="rgiege">4.创造舒适的睡眠环境。让空气流通，消除怪气味；室内安静，最好关灯；枕头合适，室外不能有响动吵扰。</p>
<p class="rgiege">5、诱导法。每进行一次深缓呼吸，就对自己进行一次暗示：“我已经睡着了。”这样就可以起到良好的诱导。</p>
<p class="dgeod">八大自我疗法</p>
<p class="rgiege">1.自我暗示法</p>
<p class="rgiege">法国大作家大仲马说过：“人生是一串由无数的烦恼组成的念珠，达观的人总是笑着念完这串念珠的。”在我们的生活中到处充满着自我暗示法，例如，清晨你对着镜子梳洗打扮一下，如果看到自己的脸色很好，往往心情舒畅，这就是一种自我暗示。假如你是一位正处于“考试焦虑”的临考中学生，你恰恰听说你的同学通过自我保健，考试焦虑情绪很快消失，你就会想，我也一定会告别“考试焦虑情绪”，做一个真正健康人。</p>
<p class="rgiege">2.睡眠消除法</p>
<p class="rgiege">事实证明，很多临考学生的“考试焦虑”是由于学习过度疲劳、睡眠不足引起的。针对这种情况，广大临考中学生朋友一般不易“夜半挑灯”苦读，要养成中午小睡的习惯。因为良好的、充足的睡眠可以消除大脑疲劳，换取充沛的精力和清醒的头脑。充足的睡眠是从容应考的前提，也是克服考试焦虑情绪行之有效的方法。</p>
<p class="rgiege">3.运动消除法</p>
<p class="rgiege">学生以脑力活动为主，而适当的运动是消除大脑疲劳的有效方法。广大临考中学生可根据自己的实际情况，散散步、打打球、做做体操。因为运动可以消除一些紧张的化学物质，虽然使肌肉疲劳，但可以放松神经。</p>
<p class="rgiege">4.兴趣消除法</p>
<p class="rgiege">人们在从事自己感兴趣的事情的时候，整个身心都会投入进去，进入一种物我两忘的境界，什么忧愁烦恼都会抛到九霄云外。因此，广大临考中学生在紧张的学习之后，做一些感兴趣的事情，如，唱唱歌、看看报、听听音乐等等，都可以消除疲劳，化解烦恼，远离考试焦虑情绪。</p>
<p class="rgiege">5.情绪宣泄法</p>
<p class="rgiege">情绪宣泄是缓解压力、保持心理平衡的重要手段。众所周知，有些考试焦虑情绪是由于坏情绪的不断积压引起的，如：升学压力使你透不过气来，考试成绩不理想，家长的-嗦等等，都可能使心情变化，久而久之，就会出现“考试焦虑情绪”。针对这种情况，可采用以下方法：聊天法，即通过向亲人或朋友，述说自己的积怨，求得他人的理解和同情，让自己的内心得到调整；哭笑法，如果内心憋得难受，又无法与人倾诉，应当找一个适宜的地方，放声大哭或大笑，以宣泄自己内心的不平；书面释放法，可以用写日记或书信的方式，释放自己的苦恼；上网法，有条件、会上网的临考中学生朋友可通过电脑网络与网友交流思想，排遣烦恼。</p>
<p class="rgiege">6.游戏转移法</p>
<p class="rgiege">即通过开展游戏活动，让处于“考试焦虑情绪”的临考中学生参与其中，进入角色，忘记疲劳，转移注意力，释放体内积聚的能量，调整机体的平衡，摆脱内心的烦恼。</p>
<p class="rgiege">7.食疗法</p>
<p class="rgiege">食疗法就是增加身体营养的方法，临考中学生脑力劳动强度大，能量消耗大，需大量补充营养。因此，必须设法增加适量含蛋白质、脂肪、碳水化合物的食物，同时还要补充大脑所需的维生素、氨基酸以及钙、铁、锌等微量元素。</p>
<p class="rgiege">8.音乐疗法</p>
<p class="rgiege">音乐能影响人的情绪行为和生理机能，不同节奏的音乐能使人放松，使人的生理、心理节奏发生良性的变化。如：圣洁、高贵的音乐，可使人净化灵魂、境界开阔；速度较缓的音乐给人以安全感、舒适感；清澈、高雅、透明的古典音乐，可以增进人们的记忆力、注意力；浪漫的音乐，可激起人们恻隐、怜悯之心；流行音乐，可使人感情投入；时尚音乐，可释放心声。</p>
<?php }?>
</div>
</div>
<?php $this->display('myroom/page_footer'); ?>
