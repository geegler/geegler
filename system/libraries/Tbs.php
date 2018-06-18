<?php

namespace System\Libraries; //echo APPPATH;

//use System\Helpers\FileLoad\Loader;
//require_once('vendor/tinybutstrong/tbs_class.php');

class GeeglerTbs extends \clsTinyButStrong
{
    private $tbs;
    private $extension;
    private $chr_open;
    private $chr_close;

    public function __construct()
    {
        parent::__construct();

        //$config = (self::getConfig());
        $config = array(
            'ldel' => '{%|',
            'rdel' => '|%}',
            'tpl_extension' => '.html');
        $this->chr_open = str_replace('|', ' ', $config['ldel']);
        $this->chr_close = str_replace('|', ' ', $config['rdel']);
        //echo $config['ldel'].'<br/>';
        $this->SetOption(array('chr_open' => $this->chr_open, 'chr_close' => $this->
                chr_close));
        $this->extension = $config['tpl_extension'];
        //echo $this->extension;
    }


    public function view($data = array(), $template, $data2 = null, $data3 = null)
        //, $data4 = null,$data5= null,$data6=null,$data7=null,$data8=null,$data9=null,$data10=null,$data11=null  )
    {
        //echo TPL_DEFAULT;
        parent::LoadTemplate(TPL_DEFAULT . $template . $this->extension);
        /* data 1 */
        parent::MergeBlock('content', $data);

        // data 2 ONLY if data 1 is defined
        if ($data2 && is_array($data2))
        {
            parent::MergeBlock('content2', $data2);
        }

        // data 3 ONLY if data 1,2 are defined
        if ($data3 && is_array($data3))
        {
            //print_r($data3);
            parent::MergeBlock('content3', $data3);
        }
        /*
        // data 4 only if data 1,2,3 are defined 
        if($data4 && is_array($data4)){
        parent::MergeBlock('content4',$data4);
        }
        // data 5 if data 1 to 4 exists 
        if($data5 && is_array($data5)){
        parent::MergeBlock('content5',$data5);
        }
        if($data6 && is_array($data6)){
        parent::MergeBlock('content6',$data6);
        }
        if($data7 && is_array($data7)){
        parent::MergeBlock('content7',$data7);
        }
        if($data8 && is_array($data8)){
        parent::MergeBlock('content8',$data8);
        }
        if($data9 && is_array($data9)){
        parent::MergeBlock('content9',$data9);
        }
        if($data10 && is_array($data10)){
        parent::MergeBlock('content10',$data10);
        }
        if($data11 && is_array($data11)){
        parent::MergeBlock('content11',$data11);
        }
        */
        parent::Show();
        return true;

    }
    /* render method is experimental for allowing the template to take multiple array */
    public function render($template, $data = array())
    {
        //echo TPL_DEFAULT;
        $x = 0;
        // parent::LoadTemplate(TPL_DEFAULT . $template . $this->extension);
        if (is_array($data))
        {

            //parent::MergeBlock('content_array','array',$data);
            foreach ($data as $item)
            {
                $x++;
                echo ('content' . $x);
                echo '<br/>';
                print_r($item);
            }
        }
        // parent::Show();
        //return true;
    }


    public static function getConfig()
    {
        $xml = Loader::load_config_xml('tbs');
        foreach ($xml->options->item as $item)
        {
            $option[] = $item->option;
            $value[] = $item->value;
        }

        $tbs_config = (array_filter(array_combine($option, $value)));

        return $tbs_config;
    }

    public static function testGeeglerTbs()
    {
        echo 'This is a test response from : ' . __class__;
    }
}
