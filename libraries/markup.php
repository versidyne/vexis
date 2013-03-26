<?php
	
	include_once "core.php";
	
	class markup extends core {
		
		private $language = false;
		private $local = false;
		public function __construct($language) { $this->language = $language; }
		
		public function column ($variable) {
			$output = false;
			if ($this->language == "xml") {
				$this->local .= "<{$variable}>";
			} elseif ($this->language == "json") {
				$this->local .= "\"{$variable}\": {";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function column_end ($variable) {
			$output = false;
			if ($this->language == "xml") {
				$this->local .= "</{$variable}>";
			} elseif ($this->language == "json") {
				$this->local .= "},";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function row ($variable, $value) {
			$output = true;
			if ($this->language == "xml") {
				$this->local .= "<{$variable}>{$value}</{$variable}>";
			} elseif ($this->language == "json") {
				$this->local .= "\"{$variable}\": \"{$value}\",";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function footer () {
			$output = true;
			if ($this->language == "xml") {
				$this->local .= "";
			} elseif ($this->language == "json") {
				$this->local .= "}";
			} elseif ($this->language == "rss") {
				$this->local .= "</channel></rss>";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function header () {
			$output = true;
			if ($this->language == "xml") {
				//header("Content-Type: application/xml; charset=ISO-8859-1");
			} elseif ($this->language == "json") {
				//header("Content-Type: application/xml; charset=ISO-8859-1");
				$this->local .= "{";
			} elseif ($this->language == "rss") {
				header("Content-Type: application/xml; charset=ISO-8859-1");
			} else {
				$output = false;
			}
			return $output;
		}
		
		//public function create() {
			//return CreateDetails() . CreateItems();
		//}
		
		public function details ($title, $link, $description, $language, $copyright, $webmaster, $category, $image, $image_title, $image_url, $image_link, $image_width, $image_height) {
			$copyright = str_replace("&copy;", "©", $copyright);
			$details = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>   
			<rss version=\"2.0\">   
				<channel>   
					<title>".$title.'</title>   
					<link>'.$link.'</link>   
					<description>'.$description.'</description>   
					<language>'.$language.'</language>
					<copyright>'.$copyright.'</copyright>
					<webMaster>'.$webmaster.'</webMaster>
					<category>'.$category.'</category>';
			if ($image == true) {
				$details .= '
				<image>   
					<title>'.$image_title.'</title>   
					<url>'.$image_url.'</url>   
					<link>'.$image_link.'</link>   
					<width>'.$image_width.'</width>   
					<height>'.$image_height.'</height>   
				</image>';
			}
			return $details;
		}
		
		public function item ($date, $title, $description, $link, $author, $guid) {
			$item = false;
			if ($this->language == "rss") {
				$item = "<item>
				<pubDate>{$date}</pubDate>
				<title>{$title}</title>
				<description>{$description}</description>
				<link>{$link}</link>
				<author>{$author}</author>
				<guid isPermaLink=\"false\">{$guid}</guid>
				</item>";
			}
			return $item;
		}
		
		// Rss Reader
		public function read($link, $clean_desc = true) {
			if ($this->language == "rss") {
				$doc = new DOMDocument();
				$doc->load($link);
				$arrFeeds = array();
				foreach ($doc->getElementsByTagName('item') as $node) {
					$itemRSS = array (
						'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
						'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
						'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
						'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue);
					if ($clean_desc == true) {
						$desc = explode("<div", $itemRSS["desc"]);
						$itemRSS['desc'] = $desc[0];
					}
					array_push($arrFeeds, $itemRSS);
				}
				return $arrFeeds;
			}
			else {
				return false;
			}
		}
		
	}
	
?>
