<?php
/**
 * Created by PhpStorm.
 * User: tangzuqiang
 * Date: 2017/10/19
 * Time: 17:04
 */
class IndexController extends  CControl {
   
    public function index()
    {
      $res=@file_get_contents('http://ip.chinaz.com/getip.aspx');
      $ip=explode("'",$res)[1];
      $obj=Ebh::app()->lib('IPaddress');
      $ret = $obj ->find($ip);
      $city=$ret[2];
      echo $city;
    }

    public function index1()
    {
        $aaaModel = $this->model('Aaa');
        $data = $aaaModel->getLists();
        $this->assign('list',$data);
        $this->display('demo/index');
    }

    public function index3()
    {
        $parameters['crid'] = $this->roominfo['crid'];

        $parameters['pagesize'] = 1;
        $parameters['p'] = 1;

        $result =   $ret = $this->apiServer->reSetting()
            ->setService('Demo.Index.index1')
            ->addParams('crid', $this->roominfo['crid'])->request();
        var_dump($result);
    }

    /**
     * 图片压缩
     */
    public function index4($imgfile='/data0/33.jpg',$minx=200,$miny=200){
        var_dump(getimagesize('/data0/33.jpg'));
        var_dump(filesize('/data0/33/jpg'));
        $im = imagecreatefromgif('/data0/33.jpg');
        var_dump($im);
        $r = imagejpeg($im,'/data0/s_33.jpg',30);
        var_dump($r);


//("picture/apple.jpg",50,50);
    }

    /**
     * @function 等比缩放函数(以保存的方式实现)
     * @param string $picname 被缩放的处理图片源
     * @param int $maxX 缩放后图片的最大宽度
     * @param int $maxY 缩放后图片的最大高度
     * @param string $pre 缩放后图片名的前缀名
     * @return string 返回后的图片名称(带路径),如a.jpg --> s_a.jpg
     */
    function scalePic($picname,$maxX=400,$maxY=400,$pre='s_')
    {
        $info = getimagesize($picname); //获取图片的基本信息
        $width = $info[0];//获取宽度
        $height = $info[1];//获取高度
        //判断图片资源类型并创建对应图片资源
        $im = $this->getPicType($info[2],$picname);
        //计算缩放比例
        $scale = ($maxX/$width)>($maxY/$height)?$maxY/$height:$maxX/$width;
        //计算缩放后的尺寸
        $sWidth = floor($width*$scale);
        $sHeight = floor($height*$scale);
        //创建目标图像资源
        $nim = imagecreatetruecolor($sWidth,$sHeight);
        //等比缩放
        imagecopyresampled($nim,$im,0,0,0,0,$sWidth,$sHeight,$width,$height);
        //输出图像
        $newPicName = $this->outputImage($picname,$pre,$nim);
        //释放图片资源
        imagedestroy($im);
        imagedestroy($nim);
        return $newPicName;
    }

    /**
     * function 判断并返回图片的类型(以资源方式返回)
     * @param int $type 图片类型
     * @param string $picname 图片名字
     * @return 返回对应图片资源
     */
    function getPicType($type,$picname)
    {
        $im=null;
        switch($type)
        {
            case 1:  //GIF
                $im = imagecreatefromgif($picname);
                break;
            case 2:  //JPG
                $im = imagecreatefromjpeg($picname);
                break;
            case 3:  //PNG
                $im = imagecreatefrompng($picname);
                break;
            case 4:  //BMP
                $im = imagecreatefromwbmp($picname);
                break;
            default:
                die("不认识图片类型");
                break;
        }
        return $im;
    }

    /**
     * function 输出图像
     * @param string $picname 图片名字
     * @param string $pre 新图片名前缀
     * @param resourse $nim 要输出的图像资源
     * @return 返回新的图片名
     */
    function outputImage($picname,$pre,$nim)
    {
        $info = getimagesize($picname);
        $picInfo = pathInfo($picname);
        $newPicName = $picInfo['dirname'].'/'.$pre.$picInfo['basename'];//输出文件的路径
        switch($info[2])
        {
            case 1:
                imagegif($nim,$newPicName);
                break;
            case 2:
                imagejpeg($nim,$newPicName,0);
                break;
            case 3:
                imagepng($nim,$newPicName,1);
                break;
            case 4:
                imagewbmp($nim,$newPicName,1);
                break;
        }
        return $newPicName;
    }
}