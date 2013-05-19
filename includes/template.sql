-- phpMyAdmin SQL Dump
-- version 4.0.0-beta1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2013 at 05:59 PM
-- Server version: 5.1.66-0+squeeze1
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vexis_osp`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `owner` int(11) NOT NULL,
  `verification` text NOT NULL,
  `group` int(11) NOT NULL,
  `key` text NOT NULL,
  `enabled` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE IF NOT EXISTS `blacklist` (
  `id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `member` int(11) NOT NULL,
  `ip` text NOT NULL,
  `reason` longtext NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE IF NOT EXISTS `children` (
  `id` int(11) NOT NULL,
  `domain` text NOT NULL,
  `database` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `type` text NOT NULL,
  `redir` text NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `domain`, `database`, `username`, `password`, `type`, `redir`, `enabled`) VALUES
(1, 'admin.osp.getvexis.com', 'vexis_osp', '', '', 'acp', '', 1),
(2, 'api.osp.getvexis.com', 'vexis_osp', '', '', 'api', '', 1),
(3, 'cdn.osp.getvexis.com', 'vexis_osp', '', '', 'cdn', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `type` text NOT NULL,
  `parent` int(11) NOT NULL,
  `body` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `first` text NOT NULL,
  `last` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `provider` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `author`, `first`, `last`, `email`, `phone`, `provider`) VALUES
(1, 1, '', '', 'test@test.com', '', 'ATT');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `title` text NOT NULL,
  `header` text NOT NULL,
  `body` longtext NOT NULL,
  `description` longtext NOT NULL,
  `stats` text NOT NULL,
  `sundries` text NOT NULL,
  `media` text NOT NULL,
  `price` double NOT NULL,
  `layout` text NOT NULL,
  `module` text NOT NULL,
  `redir` text NOT NULL,
  `shortname` text NOT NULL,
  `featured` int(11) NOT NULL,
  `navbutton` int(11) NOT NULL,
  `navparent` int(11) NOT NULL,
  `navsub` int(11) NOT NULL,
  `enabled` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `type`, `timestamp`, `author`, `category`, `title`, `header`, `body`, `description`, `stats`, `sundries`, `media`, `price`, `layout`, `module`, `redir`, `shortname`, `featured`, `navbutton`, `navparent`, `navsub`, `enabled`) VALUES
(1, 'article', 0, 0, 0, '', '', '', '', '', '', '', 0, '', '', '', '', 0, 0, 0, 0, 1),
(2, 'blog', 0, 0, 0, '', '', '', '', '', '', '', 0, '', '', '', '', 0, 0, 0, 0, 1),
(3, 'error', 1363141367, 1, 0, 'Error 404', 'Error 404', '<p>The file or directory you requested could not be found. All information regarding this incident will be reported to the administration to ensure this matter gets fixed. We apologize for any inconvenience this may have caused.</p>', '', '', '', '', 0, '', '', '', '404', 0, 0, 0, 0, 1),
(4, 'form', 1362893985, 1, 0, 'Contact', 'Contact', '<p>If you need to contact us, please use the form below.<br /><br /> <input type="hidden" name="submit" value="true" /></p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>Full Name:</td>\r\n<td><input type="text" name="name_input" value="" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Email Address:</td>\r\n<td><input type="text" name="email_input" value="" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Inquiry:</td>\r\n<td><textarea name="inquiry_input" rows="5" cols="32"></textarea></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td><input class="button" title="Submit" type="submit" value="Submit" /></td>\r\n</tr>\r\n</tbody>\r\n</table>', 'Inquire', '', 'action="?page=contact" method="post"', '', 0, '', '', '', 'contact', 0, 7, 0, 0, 1),
(5, 'form', 1362897067, 1, 0, 'Edit Profile', 'Edit Profile', '<p><input type="hidden" name="submit" value="true" /></p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>Birthday:</td>\r\n<td><input id="datepicker" type="text" name="birthday_input" value="&lt;birthday&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Homepage:</td>\r\n<td><input type="text" name="homepage_input" value="&lt;homepage&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>AIM:</td>\r\n<td><input type="text" name="aim_input" value="&lt;aim&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Windows Live:</td>\r\n<td><input type="text" name="msn_input" value="&lt;msn&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Yahoo:</td>\r\n<td><input type="text" name="yahoo_input" value="&lt;yahoo&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Biography:</td>\r\n<td><textarea name="biography_input" rows="5" cols="32"></textarea></td>\r\n</tr>\r\n<tr>\r\n<td>Location:</td>\r\n<td><input type="text" name="location_input" value="&lt;location&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Interests:</td>\r\n<td><input type="text" name="interests_input" value="&lt;interests&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>Occupation:</td>\r\n<td><input type="text" name="occupation_input" value="&lt;occupation&gt;" size="33" /></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td><input class="button" title="Save Changes" type="submit" value="Save" /></td>\r\n</tr>\r\n</tbody>\r\n</table>', '', '', 'action="?page=edit-profile" method="post"', '', 0, '', '', '', 'edit-profile', 0, 0, 0, 0, 1),
(6, 'form', 1364003439, 1, 0, 'Account Login', 'Account Login', '<p><input type="hidden" name="submit" value="true" /></p>\r\n<table style="width: 100%;">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>Email:</td>\r\n<td><input class="inputfield" type="text" name="email_input" value="{email}" size="20" /></td>\r\n</tr>\r\n<tr>\r\n<td>Password: &nbsp;</td>\r\n<td><input class="inputfield" onkeypress="CapsDetect(event)" type="password" name="password_input" size="20" /></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td><input type="checkbox" name="remember" value="true" checked="checked" /> Remember me</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td><input class="button" style="width: 75px;" title="Click to Login to the Control Panel" type="submit" value="Login" /></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td><a href="?page=login">Recover Password</a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<div align="center">{fb_form}</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '', '', 'action="?page=login" method="post"', '', 0, '', '', '', 'login', 0, 0, 0, 0, 1),
(7, 'form', 1362893949, 1, 0, 'Account Login', 'Account Login', '<p><input type=""hidden"" name=""submit"" value=""true"" /></p><table><tbody><tr><td>Email:</td><td><input class=""inputfield"" type=""text"" name=""email_input"" value="{email}" size=""12"" /></td></tr><tr><td>Password:</td><td><input class=""inputfield"" onkeypress=""CapsDetect(event)"" type=""password"" name=""password_input"" size=""12"" /></td></tr><tr><td colspan=""2""><input type=""checkbox"" name=""remember"" value=""true"" checked="checked" /> Remember me</td></tr><tr><td colspan=""2""><div align=""right""><input class=""button"" title=""Click" type=""submit"" value=""Login"" /></div></td></tr></tbody></table>', '', '', 'action="?page=login" method="post"', '', 0, '', '', '', 'loginbox', 0, 0, 0, 0, 1),
(8, 'form', 1362911424, 1, 0, 'Register', 'Registration Form', '<p><input type="hidden" name="submit" value="true" /></p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>Email Address:*</td>\r\n<td><input type="text" name="email_input" value="" size="25" /></td>\r\n</tr>\r\n<tr>\r\n<td>Password:*</td>\r\n<td><input type="password" name="password_input" value="" size="25" /></td>\r\n</tr>\r\n<tr>\r\n<td>Confirm Pass:*</td>\r\n<td><input type="password" name="pass_confirm_input" value="" size="25" /></td>\r\n</tr>\r\n<tr>\r\n<td>Nickname:*</td>\r\n<td><input type="text" name="nickname_input" value="" size="25" /></td>\r\n</tr>\r\n<tr>\r\n<td>Verification:*</td>\r\n<td><img src="?page=securimage" alt="" /><br /><input type="text" name="securimage_input" value="" size="25" /></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td><input class="button" title="Submit Registration" type="submit" value="Submit" /></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><br /> *Indicates a Required Field</p>', '', '', 'action="?page=register" method="post" onsubmit="return checkrequired(this)"', '', 0, '', '', '', 'register', 0, 0, 0, 0, 0),
(9, 'form', 1362911461, 1, 0, 'Search Engine', 'Search Engine', '<table>\r\n<tbody>\r\n<tr>\r\n<td>Criteria:</td>\r\n<td><input type="text" name="query" value="&lt;query&gt;" size="18" /> <input class="button" title="Search" type="submit" value="Search" /></td>\r\n</tr>\r\n<tr>\r\n<td colspan="2">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', '', '', 'action="?page=search" method="get"', '', 0, '', '', '', 'search', 0, 0, 0, 0, 1),
(10, 'form', 1362911411, 1, 0, 'File Uploader', 'File Uploader', '<p><input type="hidden" name="submit" value="true" /></p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td><label for="file">Choose a file to upload:</label></td>\r\n<td><input id="file" type="file" name="file" /></td>\r\n</tr>\r\n<tr>\r\n<td><input class="button" title="Submit" type="submit" value="Submit" /></td>\r\n</tr>\r\n</tbody>\r\n</table>', '', '', 'action="?page=upload" method="post" enctype="multipart/form-data"', '', 0, '', '', '', 'upload', 0, 0, 0, 0, 1),
(11, 'gallery', 0, 1, 1, 'Gallery', 'Gallery', '<div class="wrapper row2">\r\n	<div id="container" class="clear">\r\n		<!-- ####################################################################################################### -->\r\n		<!-- ####################################################################################################### -->\r\n		<!-- ####################################################################################################### -->\r\n		<!-- ####################################################################################################### -->\r\n		<div id="gallery" class="clear">\r\n			<h1>Gallery Title Goes Here</h1>\r\n			<ul>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li class="last"><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li class="last"><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li class="last"><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li class="last"><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n				<li class="last"><a href="#"><img src="skins/business/images/demo/160x160.gif" alt="" /></a></li>\r\n			</ul>\r\n			<div class="figcaption">Gallery Description Goes Here</div>\r\n		</div>\r\n		<!-- ####################################################################################################### -->\r\n		<!-- ####################################################################################################### -->\r\n		<!-- ####################################################################################################### -->\r\n		<!-- ####################################################################################################### -->\r\n		<div class="pagination">ADD PAGINATION HERE IF NEEDED</div>\r\n		<!-- ####################################################################################################### -->\r\n	</div>\r\n</div>', '', '', '', '', 0, '', '', '', 'gallery', 0, 0, 0, 0, 1),
(12, 'news', 1362885808, 1, 1, 'Testing', '', '<p>This is a test</p>', '', '', '', '', 0, '', '', '', '', 0, 0, 0, 0, 0),
(13, 'page', 1362882935, 1, 0, 'Products', 'Our Products', '<ul>\r\n<li><a href=&quot;?page=environment&quot;>Application Environment</a></li>\r\n<li><a href=&quot;?page=email-client&quot;>Email Client</a></li>\r\n<li><a href=&quot;?page=secure-terminal&quot;>Secure Terminal</a></li>\r\n<li><a href=&quot;?page=updater&quot;>Updater</a></li>\r\n<li><a href=&quot;?page=vexis-collab&quot;>Vexis Collaboration Suite</a></li>\r\n<li><a href=&quot;?page=vexis-os&quot;>Vexis Operating System</a></li>\r\n</ul>', 'Purchase', '', '', '', 0, '', '', '', 'products', 0, 4, 0, 0, 1),
(14, 'page', 1362882854, 1, 0, 'About', 'About Us', '<p>Creation<br /> <br /> The name Versidyne comes from Versi- meaning changing or adapting and -Dyne from Greek &delta;&#973;&nu;&alpha;&mu;&iota;&sigmaf; (<em>dynamis</em>) meaning power or force. This company is based on the notion of building quality systems that aren&apos;t behind the developmental curve due to capitalistic gains.<br /> <br /> We were founded in 2012, after we began to...<br /> <br /> We offer many products, most of which are currently in development and closed to the public. We specialize in secure communication software, data organization, and protection with a networking model similar to cloud based computing. We also provide website hosting, design, and development. Please visit our <a href=&quot;?page=contact&quot;>Contact Page</a> for further information.</p>\r\n<ol>\r\n<li><a href=&quot;?page=doctrine&quot;>Security Doctrine</a></li>\r\n</ol>', 'History', '', '', '', 0, 'comment', '', '', 'about', 0, 2, 0, 0, 1),
(15, 'page', 1362882903, 1, 0, 'Admin  Panel', 'Admin  Panel', '<p>If this text is displayed, please contact the administrator.</p>', '', '', '', '', 0, '', '', '', 'admin', 0, 0, 0, 0, 1),
(16, 'page', 1362882906, 1, 0, 'Disqus', 'Disqus', '<div id=&quot;disqus_thread&quot;>&nbsp;</div>\r\n<script type=&quot;text/javascript&quot;>// <![CDATA[\r\n        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */\r\n        var disqus_shortname = &apos;versidyne&apos;; // required: replace example with your forum shortname\r\n\r\n        /* * * DON&apos;T EDIT BELOW THIS LINE * * */\r\n        (function() {\r\n            var dsq = document.createElement(&apos;script&apos;); dsq.type = &apos;text/javascript&apos;; dsq.async = true;\r\n            dsq.src = &apos;http://&apos; + disqus_shortname + &apos;.disqus.com/embed.js&apos;;\r\n            (document.getElementsByTagName(&apos;head&apos;)[0] || document.getElementsByTagName(&apos;body&apos;)[0]).appendChild(dsq);\r\n        })();\r\n    \r\n// ]]></script>\r\n<noscript>Please enable JavaScript to view the <a href=&quot;http://disqus.com/?ref_noscript&quot;>comments powered by Disqus.</a></noscript>\r\n<p><a class=&quot;dsq-brlink&quot; href=&quot;http://disqus.com&quot;>comments powered by <span class=&quot;logo-disqus&quot;>Disqus</span></a></p>', '', '', '', '', 0, '', '', '', 'disqus', 0, 0, 0, 0, 0),
(17, 'page', 1362882910, 1, 0, 'Doctrine', 'Doctrine', '<h2>Structure</h2>\r\n<p><br /> The higher the class number, the more information the user is allowed to see. Each class number, as well as sector numbers, entails the information available to the ones below it. This does not apply to special access codes. To reiterate, special access codes are specific and do not entail any information other than the subject the code encompasses.<br /> <br /> Sectors are more specific than classes.<br /> </p>\r\n<h2>Classes</h2>\r\n<ol>\r\n<li>Public Data</li>\r\n<li>Private Data</li>\r\n<li>Innovative Data</li>\r\n<li>Administrative Data</li>\r\n</ol>\r\n<h2>Sectors</h2>\r\n<ol>\r\n<li>Personal Data</li>\r\n<li>Protocol Structures</li>\r\n<li>Security Methods</li>\r\n<li>Security Codes</li>\r\n</ol>\r\n<h2>Special Access</h2>\r\n<ol>\r\n<li>None to date</li>\r\n</ol>', '', '', '', '', 0, '', '', '', 'doctrine', 0, 0, 0, 0, 1),
(18, 'page', 1362882913, 1, 0, 'Donate', 'Donate', '<form action=&quot;https://www.paypal.com/cgi-bin/webscr&quot; method=&quot;post&quot;><input type=&quot;hidden&quot; name=&quot;cmd&quot; value=&quot;_s-xclick&quot; /> <input type=&quot;hidden&quot; name=&quot;encrypted&quot; value=&quot;-----BEGIN PKCS7-----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-----END PKCS7-----\r\n&quot; /> <input type=&quot;image&quot; name=&quot;submit&quot; src=&quot;https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif&quot; alt=&quot;PayPal - The safer, easier way to pay online!&quot; /> <img src=&quot;https://www.paypalobjects.com/en_US/i/scr/pixel.gif&quot; alt=&quot;&quot; width=&quot;1&quot; height=&quot;1&quot; border=&quot;0&quot; /></form>', '', '', '', '', 0, '', '', '', 'donate', 0, 0, 0, 0, 1),
(19, 'page', 1362882917, 1, 0, 'Email', 'Email', '<p>Email...</p>', '', '', '', '', 0, '', '', '', 'email', 0, 0, 0, 0, 1),
(20, 'page', 1362882817, 1, 0, '', 'Home', '<p>The name Versidyne comes from Versi- meaning changing or adapting and -Dyne from Greek &delta;&#973;&nu;&alpha;&mu;&iota;&sigmaf; (<em>dynamis</em>) meaning power or force. This company is based on the notion of building quality systems that aren&apos;t behind the developmental curve due to capitalistic gains. <a href=&quot;?page=about&quot;>More &raquo;</a></p>', '', '', '', '', 0, 'home', '', '', 'home', 0, 1, 0, 0, 1),
(21, 'page', 1362882926, 1, 0, 'Member  Panel', 'Member Panel', 'Welcome, <nickname>.  This menu has been formulated for optimum display with <browser> <version>. <message>\n<ul>\n<extensions>\n</ul> \n<notice>', '', '', '', '', 0, '', '', '', 'member', 0, 0, 0, 0, 1),
(22, 'page', 1362882928, 1, 0, 'News', 'News', '<p>If this text is displayed, please contact the administrator.</p>', 'Updates', '', '', '', 0, 'news', '', '', 'news', 0, 3, 0, 0, 1),
(23, 'page', 1362882941, 1, 0, 'Terms of Service', 'Terms of Service', '<h2>1. Terms</h2>\r\n<p>By accessing this web site, you are agreeing to be bound by these web site Terms and Conditions of Use, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained in this web site are protected by applicable copyright and trade mark law.</p>\r\n<h2>2. Use License</h2>\r\n<ol type=&quot;a&quot;>\r\n<li>Permission is granted to temporarily download one copy of the materials (information or software) on Versidyne LLC&apos;s web site for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:<ol type=&quot;i&quot;>\r\n<li>modify or copy the materials;</li>\r\n<li>use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>\r\n<li>attempt to decompile or reverse engineer any software contained on Versidyne LLC&apos;s web site;</li>\r\n<li>remove any copyright or other proprietary notations from the materials; or</li>\r\n<li>transfer the materials to another person or &quot;mirror&quot; the materials on any other server.</li>\r\n</ol></li>\r\n<li>This license shall automatically terminate if you violate any of these restrictions and may be terminated by Versidyne LLC at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.</li>\r\n</ol>\r\n<h2>3. Disclaimer</h2>\r\n<ol type=&quot;a&quot;>\r\n<li>The materials on Versidyne LLC&apos;s web site are provided &quot;as is&quot;. Versidyne LLC makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, Versidyne LLC does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its Internet web site or otherwise relating to such materials or on any sites linked to this site.</li>\r\n</ol>\r\n<h2>4. Limitations</h2>\r\n<p>In no event shall Versidyne LLC or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption,) arising out of the use or inability to use the materials on Versidyne LLC&apos;s Internet site, even if Versidyne LLC or a Versidyne LLC authorized representative has been notified orally or in writing of the possibility of such damage. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.</p>\r\n<h2>5. Revisions and Errata</h2>\r\n<p>The materials appearing on Versidyne LLC&apos;s web site could include technical, typographical, or photographic errors. Versidyne LLC does not warrant that any of the materials on its web site are accurate, complete, or current. Versidyne LLC may make changes to the materials contained on its web site at any time without notice. Versidyne LLC does not, however, make any commitment to update the materials.</p>\r\n<h2>6. Links</h2>\r\n<p>Versidyne LLC has not reviewed all of the sites linked to its Internet web site and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by Versidyne LLC of the site. Use of any such linked web site is at the user&apos;s own risk.</p>\r\n<h2>7. Site Terms of Use Modifications</h2>\r\n<p>Versidyne LLC may revise these terms of use for its web site at any time without notice. By using this web site you are agreeing to be bound by the then current version of these Terms and Conditions of Use.</p>\r\n<h2>8. Governing Law</h2>\r\n<p>Any claim relating to Versidyne LLC&apos;s web site shall be governed by the laws of the State of California without regard to its conflict of law provisions.</p>\r\n<p>General Terms and Conditions applicable to Use of a Web Site.</p>\r\n<h2>Privacy Policy</h2>\r\n<p>Your privacy is very important to us. Accordingly, we have developed this Policy in order for you to understand how we collect, use, communicate and disclose and make use of personal information. The following outlines our privacy policy.</p>\r\n<ul>\r\n<li>Before or at the time of collecting personal information, we will identify the purposes for which information is being collected.</li>\r\n<li>We will collect and use of personal information solely with the objective of fulfilling those purposes specified by us and for other compatible purposes, unless we obtain the consent of the individual concerned or as required by law.</li>\r\n<li>We will only retain personal information as long as necessary for the fulfillment of those purposes.</li>\r\n<li>We will collect personal information by lawful and fair means and, where appropriate, with the knowledge or consent of the individual concerned.</li>\r\n<li>Personal data should be relevant to the purposes for which it is to be used, and, to the extent necessary for those purposes, should be accurate, complete, and up-to-date.</li>\r\n<li>We will protect personal information by reasonable security safeguards against loss or theft, as well as unauthorized access, disclosure, copying, use or modification.</li>\r\n<li>We will make readily available to customers information about our policies and practices relating to the management of personal information.</li>\r\n</ul>\r\n<p>We are committed to conducting our business in accordance with these principles in order to ensure that the confidentiality of personal information is protected and maintained.</p>', '', '', '', '', 0, '', '', '', 'terms_of_service', 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `meid` text NOT NULL,
  `sim` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discrete`
--

CREATE TABLE IF NOT EXISTS `discrete` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `type` text NOT NULL,
  `variable` text NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `name` text NOT NULL,
  `category` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `version` text NOT NULL,
  `file` text NOT NULL,
  `stats` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `name` text NOT NULL,
  `node` int(11) NOT NULL,
  `mime` text NOT NULL,
  `type` text NOT NULL,
  `src` text NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `allowed` text NOT NULL,
  `restricted` text NOT NULL,
  `special` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `allowed`, `restricted`, `special`) VALUES
(1, 'Administration', 'admin,member,edit-profile,upload', '', 'developer,moderator'),
(2, 'Moderators', 'member,edit-profile,upload', 'admin', 'moderator'),
(3, 'Developers', 'member,edit-profile,upload', 'admin', 'developer'),
(4, 'Verified Members', 'member,edit-profile,upload', 'admin', ''),
(5, 'Unverified Members', 'member,edit-profile', 'admin,upload', ''),
(6, 'Banned Members', '', 'admin,member,edit-profile,upload', ''),
(7, 'General Public', '', 'admin,member,edit-profile,upload', '');

-- --------------------------------------------------------

--
-- Table structure for table `headers`
--

CREATE TABLE IF NOT EXISTS `headers` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `mime` text NOT NULL,
  `rel` text NOT NULL,
  `src` text NOT NULL,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `scheme` text NOT NULL,
  `remote` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `headers`
--

INSERT INTO `headers` (`id`, `type`, `mime`, `rel`, `src`, `name`, `content`, `scheme`, `remote`, `enabled`) VALUES
(1, 'link', 'application/rss+xml', 'alternate', '{website}?page=news&output=rss', '{company} - News', '', '', 0, 1),
(2, 'link', 'text/css', 'stylesheet', '{website}skins/{skin}/styles/default.css', '', '', '', 0, 1),
(3, 'link', 'text/css', 'stylesheet', '{website}skins/{skin}/styles/schemes/default.css', '', '', '', 0, 1),
(4, 'link', 'text/css', 'stylesheet', '{website}styles/admin/toolbars/adminbar.css', '', '', '', 0, 1),
(5, 'link', '', 'icon', '{website}styles/icons/{favicon}', '', '', '', 0, 1),
(6, 'link', 'image/x-icon', 'shortcut icon', '{website}styles/icons/{favicon}', '', '', '', 0, 1),
(7, 'link', 'text/css', 'stylesheet', '{website}styles/jquery/core.css', '', '', '', 0, 0),
(8, 'link', 'text/css', 'stylesheet', '{website}styles/jquery/{jqueryskin}/jquery-ui.min.css', '', '', '', 0, 1),
(9, 'link', 'text/css', 'stylesheet', '{website}styles/slideshow/default.css', '', '', '', 0, 1),
(10, 'meta', 'content-type', '', '', '', 'text/html; charset=iso-8859-1', '', 0, 1),
(11, 'meta', 'imagetoolbar', '', '', '', 'no', '', 0, 1),
(12, 'script', 'text/javascript', '', '', '', '{script-data}', '', 0, 1),
(13, 'script', 'text/javascript', '', 'ajax.js', '', '', '', 0, 0),
(14, 'script', 'text/javascript', '', 'functions.js', '', '', '', 0, 0),
(15, 'script', 'text/javascript', '', 'jquery.min.js', '', '', '', 0, 1),
(16, 'script', 'text/javascript', '', 'jquery.ui.min.js', '', '', '', 0, 1),
(17, 'script', 'text/javascript', '', 'jquery.ui.initiate.js', '', '', '', 0, 1),
(18, 'script', 'text/javascript', '', 'jquery.nivo.slider.min.js', '', '', '', 0, 0),
(19, 'script', 'text/javascript', '', 'jquery.nivo.slider.initiate.js', '', '', '', 0, 0),
(20, 'script', 'text/javascript', '', 'jquery.slides.min.js', '', '', '', 0, 0),
(21, 'script', 'text/javascript', '', 'jquery.slides.initiate.js', '', '', '', 0, 0),
(22, 'script', 'text/javascript', '', 'jquery.easing.js', '', '', '', 0, 1),
(23, 'script', 'text/javascript', '', 'jquery.hoverintent.js', '', '', '', 0, 1),
(45, 'script', 'text/javascript', '', '', '', 'var _gaq = _gaq || [];\n_gaq.push([''_setAccount'', ''{google-analytics}'']);\n_gaq.push([''_trackPageview'']);\n\n(function() {\nvar ga = document.createElement(''script''); ga.type = ''text/javascript''; ga.async = true;\nga.src = (''https:'' == document.location.protocol ? ''https://ssl'' : ''http://www'') + ''.google-analytics.com/ga.js'';\nvar s = document.getElementsByTagName(''script'')[0]; s.parentNode.insertBefore(ga, s);\n})();', '', 0, 1),
(46, 'link', 'text/css', 'stylesheet', 'styles/emoticons/default.css', '', '', '', 0, 1),
(47, 'script', 'text/javascript', '', 'jquery.emoticons.min.js', '', '', '', 0, 1),
(48, 'script', 'text/javascript', '', 'jquery.emoticons.initiate.js', '', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `limbo`
--

CREATE TABLE IF NOT EXISTS `limbo` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `timestamp` text NOT NULL,
  `author` int(11) NOT NULL,
  `data` text NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL DEFAULT '0',
  `group` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `nickname` text NOT NULL,
  `associates` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `group`, `email`, `password`, `nickname`, `associates`) VALUES
(1, 1, 'support@versidyne.com', '', 'Admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `body` text NOT NULL,
  `recipient` int(11) NOT NULL,
  `read` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `hostname` text NOT NULL,
  `ip` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `priority` text NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `timestamp` text NOT NULL,
  `author` text NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL,
  `name` text NOT NULL,
  `price` text NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL,
  `first` text NOT NULL,
  `last` text NOT NULL,
  `birthday` text NOT NULL,
  `homepage` text NOT NULL,
  `aim` text NOT NULL,
  `msn` text NOT NULL,
  `yahoo` text NOT NULL,
  `biography` text NOT NULL,
  `location` text NOT NULL,
  `interests` text NOT NULL,
  `occupation` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schemes`
--

CREATE TABLE IF NOT EXISTS `schemes` (
  `id` int(11) NOT NULL,
  `table` text NOT NULL,
  `type` text NOT NULL,
  `attribute` text NOT NULL,
  `data` text NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schemes`
--

INSERT INTO `schemes` (`id`, `table`, `type`, `attribute`, `data`, `enabled`) VALUES
(1, 'products', 'text', 'category', '', 1),
(2, 'products', 'text', 'price', '', 1),
(3, 'products', 'text', 'name', '', 1),
(4, 'products', 'text', 'description', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `search`
--

INSERT INTO `search` (`id`, `type`, `value`) VALUES
(1, 'suggestion', 'Computer'),
(2, 'suggestion', 'Program'),
(3, 'suggestion', 'Website'),
(4, 'suggestion', 'Computer Technology'),
(5, 'suggestion', 'Program Language'),
(6, 'suggestion', 'Website Design'),
(7, 'suggestion', 'Computer Program'),
(8, 'suggestion', 'Computers'),
(9, 'suggestion', 'Programs'),
(10, 'suggestion', 'Websites');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `session` text NOT NULL,
  `identifier` text NOT NULL,
  `key` text NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `variable` text NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `category` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `variable`, `value`, `description`, `type`, `category`) VALUES
(1, 'admin_email', 'alex.gurrola@versidyne.com', 'Administrator Email', 'email', 1),
(2, 'company', 'Vexis OSP', 'Company Name', 'text', 1),
(3, 'cookie_directory', '/', 'Cookie Directory', 'text', 1),
(4, 'cookie_prefix', 'vexis_osp', 'Cookie Prefix', 'text', 1),
(5, 'copyright', 'Copyright &copy; 2009-2013 by Versidyne LLC, All Rights Reserved.', 'Copyright', 'text', 1),
(6, 'domain', 'osp.getvexis.com', 'Domain Name', 'text', 1),
(7, 'donations', '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">\r\n<input type="hidden" name="cmd" value="_s-xclick">\r\n<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----\r\n">\r\n<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">\r\n<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">\r\n</form>\r\n', 'Donations', 'html', 1),
(8, 'email_domain', 'versidyne.com', 'Email Domain', 'text', 1),
(9, 'email_quota', '25', 'Email Quota (MB)', 'integer', 1),
(10, 'emulation_location', 'https://www.vbulletin.com/forum/forum.php', 'Emulation Location', 'text', 1),
(11, 'favicon', 'v-modern.ico', 'Favicon', 'skin', 3),
(12, 'footer', 'Copyright &copy; 2009-2013 by <a href="http://www.versidyne.com/">Versidyne Labs</a>, All Rights Reserved.', 'Footer', 'html', 1),
(13, 'google_analytics', 'UA-37213453-8', 'Google Analytics', 'text', 1),
(14, 'https_prefix', 'false', 'HTTPS Prefix', 'boolean', 1),
(15, 'http_auth', 'false', 'HTTP Authentication', 'boolean', 1),
(16, 'jquery_skin', 'ui-darkness', 'jQuery Site', 'skin', 3),
(17, 'language', 'en-us', 'Default Language', 'language', 1),
(18, 'link_auth', '<a href="?page=member">Control Panel</a> | <a href="?page=logout">Logout</a>', 'Authorized Links', 'html', 1),
(19, 'link_unauth', '<a href="?page=register">Register</a> | <a href="?page=login">Login</a>', 'Unauthorized Links', 'html', 1),
(20, 'maintenance', 'false', 'Lock Website', 'boolean', 2),
(21, 'max_filesize', '26214400', 'Maximum Filesize', 'integer', 1),
(22, 'media_cdn', 'http://cdn.getvexis.com/', 'Media CDN', 'text', 1),
(23, 'member_message', '', 'Member Message', 'text', 1),
(24, 'member_notice', '', 'Member Notice', 'text', 1),
(25, 'meta_keywords', 'computers, software,', 'Meta Keywords', 'text', 1),
(26, 'nonexistent_message', 'Account does not exist', 'Nonexistent Account', 'text', 1),
(27, 'proxy_list', '', 'Proxy List', 'text', 1),
(28, 'search_desc_length', '75', 'Search Desc Length', 'integer', 1),
(29, 'session_timeout', '3600', 'Session Timeout', 'integer', 1),
(30, 'skin', 'fusionedge', 'Skin', 'skin', 3),
(31, 'slogan', '<i>We don''t speak in code</i>', 'Slogan', 'text', 1),
(32, 'sponsors', '<li><a href="#"><img src="skins/modern-business/images/demo/125x125.gif" alt="" /></a></li>\r\n<li><a href="#"><img src="skins/modern-business/images/demo/125x125.gif" alt="" /></a></li>\r\n<li><a href="#"><img src="skins/modern-business/images/demo/125x125.gif" alt="" /></a></li>\r\n<li><a href="#"><img src="skins/modern-business/images/demo/125x125.gif" alt="" /></a></li>\r\n<li><a href="#"><img src="skins/modern-business/images/demo/125x125.gif" alt="" /></a></li>\r\n<li class="last"><a href="#"><img src="skins/modern-business/images/demo/125x125.gif" alt="" /></a></li>', 'Sponsors', 'html', 1),
(33, 'time_offset', '-8', 'Time Offset', 'text', 1),
(34, 'time_zone', 'GMT', 'Time Zone', 'text', 1),
(35, 'upload_dir', 'files', 'Upload Directory', 'directory', 1),
(36, 'webmail', 'http://email.getvexis.com/', 'Webmail Url', 'text', 1),
(37, 'world_news_rss_link', 'http://feeds.reuters.com/reuters/worldNews', 'World News (RSS)', 'text', 1),
(38, 'www_prefix', 'false', 'WWW Prefix', 'boolean', 1),
(39, 'acp_loc', 'http://admin.osp.getvexis.com/', 'Admin CP Location', 'text', 1),
(40, 'acp_domain', 'admin.osp.getvexis.com', 'Admin CP Domain', 'text', 1),
(41, 'acp_jquery_skin', 'flick', 'jQuery Admin', 'skin', 3);

-- --------------------------------------------------------

--
-- Table structure for table `skins`
--

CREATE TABLE IF NOT EXISTS `skins` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `navbar` text NOT NULL,
  `subnav` text NOT NULL,
  `featured` text NOT NULL,
  `featured_cells` int(11) NOT NULL,
  `featured_limit` int(11) NOT NULL,
  `search` text NOT NULL,
  UNIQUE KEY `id_3` (`id`),
  KEY `1` (`id`),
  KEY `1_2` (`id`),
  KEY `1_3` (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skins`
--

INSERT INTO `skins` (`id`, `name`, `content`, `navbar`, `subnav`, `featured`, `featured_cells`, `featured_limit`, `search`) VALUES
(1, 'fusionedge', '', '<li class=''<class>''><a href=''?page=<shortname>''><title></a><navsub></li>', '<li class=''<class>''><a href=''?page=<shortname>''><title></a></li>', '<article class="one_third <class>">\r\n<figure class="clear"><img src="skins/<skin>/images/demo/48x48.gif" width="48" height="48" alt="">\r\n<figcaption>\r\n<h2><title></h2>\r\n<p><description><a href="?page=<shortname>">Continue Reading &raquo;</a></p>\r\n</figcaption>\r\n</figure>\r\n</article>', 3, 6, '<form action="<action>" method="get">\r\n<fieldset>\r\n<legend>Search:</legend>\r\n<input id="query" name="query" type="text" value="Search Our Website&hellip;" onFocus="this.value=(this.value==''Search Our Website&hellip;'')? '''' : this.value ;" onkeyup="searchSuggest();" autocomplete="off">\r\n<input type="submit" id="sf_submit" value="submit">\r\n</fieldset>\r\n</form>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL,
  `member` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE IF NOT EXISTS `verification` (
  `id` int(11) NOT NULL,
  `member` int(11) NOT NULL,
  `code` text NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
