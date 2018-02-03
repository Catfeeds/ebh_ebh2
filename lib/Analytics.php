<?php
/**
 *统计代码
 */
class Analytics{
  private $tag;
  public function get($name = 'baidu',$tag = ''){
      $this->tag = $tag;
      if(IS_DEBUG){
        return '';
      }else{
        return $this->$name();
      }
  }
	
  public function __call($fname,$args){
    return '';
  }
  /**百度统计代码**/
  public function baidu(){
    $uri = Ebh::app()->getUri();
    $curdomain =  $uri->curdomain;
    $ebh = <<<EOT
    <div style="display:none">
    <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?97ff601394bc14795cc836a8a41f7d7d";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
      </script>
    </div>
EOT;

    $ebanhui = <<<EOT
    <div style="display:none">
      <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?92f930c567dfe34c08ce46827d9e9ccd";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
      </script>
    </div>
EOT;
    $www_ebh = <<<EOT
    <div style="display:none">
     <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?ad547775d3c0d40d1961922b7a8629b2";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
      </script>
    </div>
EOT;
    if(!empty($this->tag) && !empty(${$this->tag}) ){
      echo ${$this->tag};
      return;
    }
    if($curdomain=='ebanhui.com'){
      echo $ebanhui;
    }else{
      echo $ebh;
    }
  }
}
