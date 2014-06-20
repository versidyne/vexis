<?php
	
	include_once "core.php";
	
	class markup extends core {
		
		private $language = false;
		private $local = false;
		public function __construct($language) { $this->language = $language; }
		
		public function column ($variable) {
			$output = true;
			if ($this->language == "json") {
				$this->local .= "\"{$variable}\": {\n";
			} elseif ($this->language == "xml") {
				$this->local .= "<{$variable}>\n";
			} elseif ($this->language == "rss") {
				$this->local .= "<{$variable}>\n";
			} elseif ($this->language == "atom") {
				$this->local .= "<{$variable}>\n";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function column_end ($variable) {
			$output = true;
			if ($this->language == "json") {
				$this->local .= "},\n";
			} elseif ($this->language == "xml") {
				$this->local .= "</{$variable}>\n";
			} elseif ($this->language == "rss") {
				$this->local .= "</{$variable}>\n";
			} elseif ($this->language == "atom") {
				$this->local .= "</{$variable}>\n";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function row ($variable, $value) {
			$output = true;
			if ($this->language == "json") {
				$this->local .= "\"{$variable}\": \"{$value}\",\n";
			} elseif ($this->language == "xml") {
				$this->local .= "<{$variable}>{$value}</{$variable}>\n";
			} elseif ($this->language == "rss") {
				$this->local .= "<{$variable}>{$value}</{$variable}>\n";
			} elseif ($this->language == "atom") {
				$this->local .= "<{$variable}>{$value}</{$variable}>\n";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function footer () {
			$output = true;
			if ($this->language == "json") {
				$this->local .= "}";
			} elseif ($this->language == "xml") {
				$this->local .= "";
			} elseif ($this->language == "rss") {
				$this->local .= "</channel></rss>";
			} elseif ($this->language == "atom") {
				$this->local .= "</feed>";
			} else {
				$output = false;
			}
			return $output;
		}
		
		public function header () {
			$output = true;
			if ($this->language == "json") {
				header("Content-Type: application/xml; charset=ISO-8859-1");
				$this->local .= "{\n";
			} elseif ($this->language == "xml") {
				header("Content-Type: application/xml; charset=ISO-8859-1");
				$this->local .= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
			} elseif ($this->language == "rss") {
				header("Content-Type: application/rss+xml; charset=ISO-8859-1");
				$this->local .= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?><rss version=\"2.0\"><channel>\n";
			} elseif ($this->language == "atom") {
				header("Content-Type: application/atom+xml; charset=ISO-8859-1");
				$this->local .= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?><feed xmlns=\"http://www.w3.org/2005/Atom\">\n";
			} else {
				$output = false;
			}
			return $output;
		}
		
		// Export local data
		public function export() {
			return $this->local;
		}
		
		/*public function create() {
			return CreateDetails() . CreateItems();
		}*/
		
		// RSS Details
		public function details ($info) {
			$output = true;
			if ($this->language == "rss") {
				$info['copyright'] = str_replace("&copy;", "©", $info['copyright']);
				$this->local .= "<title>{$info['title']}</title>
						<link>{$info['link']}</link>
						<description>{$info['description']}</description>
						<language>{$info['language']}</language>
						<copyright>{$info['copyright']}</copyright>
						<webMaster>{$info['webmaster']}</webMaster>
						<category>{$info['category']}</category>\n";
				if ($image == true) {
					$this->local .= "<image>
						<title>{$info['image_title']}</title>   
						<url>{$info['image_url']}</url>   
						<link>{$info['image_link']}</link>   
						<width>{$info['image_width']}</width>   
						<height>{$info['image_height']}</height>   
					</image>\n";
				}
			} else {
				$output = false;
			}
			return $output;
		}
		
		// RSS Items
		public function item ($date, $title, $description, $link, $author, $guid) {
			$output = true;
			if ($this->language == "rss") {
				$this->local .= "<item>
					<pubDate>{$date}</pubDate>
					<title>{$title}</title>
					<description>{$description}</description>
					<link>{$link}</link>
					<author>{$author}</author>
					<guid isPermaLink=\"false\">{$guid}</guid>
				</item>\n";
			} else {
				$output = false;
			}
			return $output;
		}
		
		// RSS Reader
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
