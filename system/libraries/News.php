<?php namespace System\Libraries;

use \ DOMDocument;

Class NewsFeeds
{
	private $source, $xml, $limit;
	
	public function __construct($source, $limit = null){
		if($limit){
			$this->limit = $limit;
		}else{
			$this->limit = 10;
		}
		$this->source = $source;
		//find out which feed was selected
	if($this->source =="Google") {
	  $this->xml=("https://news.google.com/news/rss/?gl=US&ned=us&hl=en");
	} elseif($this->source=="NBC") {
	  $this->xml=("http://rss.msnbc.msn.com/id/3032091/device/rss/rss.xml");
	}
		
	}
function getNews(){

		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->xml);

		//get elements from "<channel>"
		$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
		$channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
		$channel_link = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
		$channel_desc = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
		$channel_info = [
							'channel_link' => $channel_link,
							'channel_title' => $channel_title,
							'channel_desc' => $channel_desc,
						];

		$news_item = array();
		$x=$xmlDoc->getElementsByTagName('item');
		for ($i=0; $i<=$this->limit; $i++) {
		  $news_item['title'] =$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
		  $news_item['link'] =$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
		  $news_item['desc']=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
		 
		  $news_items[] = $news_item;
		}
		 return(array('info' => $channel_info,'items'=>$news_items));
	}
}
/* usage example */
/*
use System\Libraries\NewsFeeds;
$obj = new NewsFeeds('Google');
$news = $obj->getNews(); //('Google');

echo '<a href="'.$news['info']['channel_link'] .'">'. $news['info']['channel_title'].'</a><br/>';
echo $news['info']['channel_desc'] .'<br/>';
//var_dump($news['items']);

foreach($news['items'] as $item){
		echo '<p><a href="'.$item['link'].'">'.$item['title'].'</a><br/>';
		echo $item['desc'].'</p>';
	
	
}
*/
