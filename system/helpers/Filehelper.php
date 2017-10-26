<?php

namespace System\Helpers\File;
use System\Helpers\Curl\CurlHelper;

/**
 * FileHelper
 * 
 * @package   
 * @author demos
 * @copyright designer
 * @version 2015
 * @access public
 */
final class FileHelper
{

    /**
     * FileHelper::__construct()
     * 
     * @return
     */
    public function __construct()
    {

    }

    /**
     * FileHelper::check_dir()
     * 
     * @param mixed $dir
     * @return boolean
     */
    public static function check_dir($dir)
    {

        if(!is_readable($dir))
            return null;
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if($entry != "." && $entry != "..") {
                return false;
            }

            return true;
        }
    }

    /**
     * FileHelper::get_summary()
     * 
     * @return array()
     */
    public static function get_summary()
    {
        //$this->settings = Set::settings();
        if(file_exists(CONTENT_DIR . 'summary/summary.txt')) {
            // Open the text file and get the content

            $handle = fopen(CONTENT_DIR . 'summary/summary.txt', 'r');
            $data = fread($handle, filesize(CONTENT_DIR . 'summary/summary.txt'));
            $rowsArr = self::explodeMenuRows($data);
            for ($i = 0; $i < (count($rowsArr) - 1); $i++) {
                $line_entries = self::explodeLines($rowsArr[$i]);

                $item = array(
                    'author' => $line_entries[0],
                    'title' => $line_entries[1],
                    'url' => $line_entries[2],
                    'content' => $line_entries[3]);

                $items[] = $item;

            }
            return ($items);
        }

    }
    /**
     * FileHelper::explodeMenuRows()
     * 
     * @param mixed $data
     * @return array()
     */
    public static function explodeMenuRows($data)
    {
        $rowsArr = explode("\n", $data);
        return $rowsArr;
    }

    /*
    * return menu items
    */
    /**
     * FileHelper::explodeLines()
     * 
     * @param mixed $singleLine
     * @return
     */
    public static function explodeLines($singleLine)
    {
        $items = explode("|", $singleLine);
        return $items;
    }

    /*
    * parse menu text file
    *returns array
    */
    /**
     * FileHelper::parse_menu()
     * 
     * @return returns array
     */
    public static function parse_menu()
    {
        $doc = new DOMDocument();
        $doc->load(CONTENT_DIR . 'menu/menu.xml');
        $menus = $doc->getElementsByTagName("menu");
        foreach ($menus as $item) {
            $links = $item->getElementsByTagName("link");
            $items['link'] = $links->item(0)->nodeValue;
            $urls = $item->getElementsByTagName("url");
            $items['url'] = $urls->item(0)->nodeValue;

            $menu[] = $items;
        }
        //print_r($menu);
        return ($menu);

    }

    /*
    * this is an xml article generator
    */

    /**
     * FileHelper::write_article()
     * 
     * @return
     */
    public static function write_article()
    {

    }
    /*
    *this is an optional xml menu generator 
    * returns xml file 
    */
    /**
     * FileHelper::set_menu()
     * 
     * @return write xml file
     */
    public static function set_menu()
    {
        $doc = new DOMDocument();
        $doc->formatOutput = true;


        $files = (glob(CONTENT_DIR . 'menu/menu.xml'));
        $items = $doc->createElement("menus");
        $doc->appendChild($items);
        foreach ($files as $filename) {

            $item = $doc->createElement("menu");

            $link = $doc->createElement("link");
            $link->appendChild($doc->createTextNode(ucwords(str_replace('_', ' ', pathinfo($filename,
                PATHINFO_FILENAME)))));
            $item->appendChild($link);

            $url = $doc->createElement("url");
            $url->appendChild($doc->createTextNode('title=' . pathinfo($filename,
                PATHINFO_FILENAME)));
            $item->appendChild($url);

            $items->appendChild($item);
        }
        $menu_xml = $doc->saveXML();

        $handle = @fopen(CONTENT_DIR . 'menu/menu.xml', 'w');
        fwrite($handle, $menu_xml);
        fclose($handle);

    }

    /*
    * parse text file
    * returns array
    */
    /**
     * FileHelper::parse_textfile()
     * 
     * @param mixed $file
     * @return
     */
    public static function parse_textfile($file)
    {

        $textfile_content = file_get_contents($file);
        $article = explode("|", $textfile_content);
        return (array(
            'title' => $article[1],
            'author' => $article[0],
            'content' => $article[2]));
    }
    /*
    * parse article xml file // this is an optional features
    * returns array
    */
    /**
     * FileHelper::parse_article()
     * 
     * @param mixed $file
     * @return
     */
    public static function parse_article($file)
    {

        $doc = new DOMDocument();
        $doc->load($file);

        $articles = $doc->getElementsByTagName("article");
        foreach ($articles as $article) {
            $authors = $article->getElementsByTagName("author");
            $author = $authors->item(0)->nodeValue;

            $content = $article->getElementsByTagName("content");
            $content = $content->item(0)->nodeValue;

            $titles = $article->getElementsByTagName("title");
            $title = $titles->item(0)->nodeValue;

            return array(
                'title' => $title,
                'author' => $author,
                'content' => str_replace(PHP_EOL, "&lt;br/&gt;", $content));
        }

    }


    public static function parse_json($file)
    {

        if(file_exists(JSON_DIR . $file . '.json')) {
            $json_file = file_get_contents(JSON_DIR . $file . '.json');
            //echo $json_file;
            $json_data = json_decode($json_file, true);
            //print_r($json_data);
            //print_r($json_data);
            //return($json_data->$p1->$p2);
            return ($json_data);

        }

    }

    public static function test_parse_json($file,$object = false){
        if(file_exists($file.'.json')){
            $json_file = file_get_contents($file.'.json');
            //$json_data = json_decode($json_file, $object);
            return($json_file);
        }
    }

    public static function parse_remotejson($file, $object = false)
    {
        $remotefile = CurlHelper::getRemoteFile($file);
        if($object) {
            return (json_decode($remotefile, $object));
        }
        return (json_decode($remotefile, $object));

    }

    public static function testFileHelper()
    {
        echo 'this is from filehelper ' . __namespace__ . '<br/>';
    }
}
