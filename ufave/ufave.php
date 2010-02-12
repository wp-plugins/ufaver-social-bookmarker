<?php
/*
Plugin Name: uFave.us Social Bookmarking Widget
Plugin URI: http://www.credits4gifts.com
Description: Help your visitors promote your site or blog. Add this widget to yor blog so everyone can bookmark your articles. You can save up to 90% of your time by using this widget than copy / pasting each article. It works with all popular bookmarking services.
Author: uFave.us
Author URI: http://www.credits4gifts.com
Version: 1.0.0


*/


$ufaveWidgetTitle="uFave Social Bookmarking Widget";
$ufaveSelectedLinks="del.icio.us;Digg;StumbleUpon;";
$ufaveListView=0;
$ufaveButton=0;
$ufaveMoreLink=1;
$ufaveHideBrand=0;
$ufaveCenterFade=1;
$ufaveDocType="XHTML";
$ufaveIconDir="http://".$_SERVER['SERVER_NAME'].dirname(__FILE__);



$ufaveMoreStyleWritten=false;


if(!isset($ufaveCount))
	$ufaveCount=0;


function createufave($title, $url, $inBlog=false)
{
	global $ufaveCount;
	global $ufaveWidgetTitle;
	global $ufaveSelectedLinks;
	global $ufaveListView;
	global $ufaveButton;
	global $ufaveMoreLink;
	global $ufaveHideBrand;
	global $ufaveCenterFade;
	global $ufaveDocType;
	global $ufaveIconDir;

	global $ufaveMoreStyleWritten;

	global $doing_rss;
	
	// Strings for I18n
	
	if($inBlog)
	{
		load_plugin_textdomain('ufave', 'wp-content/plugins/ufave');

		$loc=__("en_US", 'ufave');
		$more=__("More", 'ufave');
		$bookmarkAndShare=__("<img src=/wp-content/plugins/ufave/images/minilogo.png>", 'ufave');
		$closeThisWindow=__("Close window", 'ufave');
		$ufaveSaveToBrowserFavorites=__("Bookmark this page on your computer", 'ufave');
		$emailThisToAFriend=__("Email this article to a friend", 'ufave');
		$or=__("or", 'ufave');
		$poweredBy=__("Powered by", 'ufave');
	}
	else
	{
		$loc=_("en_US");
		$more=_("More");
		$bookmarkAndShare=_("<img src=/wp-content/plugins/ufave/images/minilogo.png>");
		$closeThisWindow=_("Close window");
		$ufaveSaveToBrowserFavorites=_("Bookmark this page on your computer");
		$emailThisToAFriend=_("Email this article to a friend");
		$or=_("or");
		$poweredBy=_("Powered by");
	}
	

	
	$ufaveLinks=getufaveLinks($title, $url, $loc);

		
	$ufaveCount++;

	
	$ufaveLinkTarget="_blank";

	
	$listView = $ufaveListView;

		
	if($inBlog)
	{
		$inFeed=(is_feed() || $doing_rss);
		
		{		
			$widgetTitle = $ufaveWidgetTitle;
			$feedBurnerID = $ufaveFeedBurnerID;
			$feedBurnerAddress = "";
			$moreLink = $ufaveMoreLink;
			$hideBrand = $ufaveHideBrand;
			$centerFade = $ufaveCenterFade;
			$docType = $ufaveDocType;
		}
		
				
		if($feedBurnerAddress=="")
			$feedURL=get_bloginfo_rss('rss2_url');
		else
			$feedURL="http://feeds.feedburner.com/".$feedBurnerAddress;

			
		$iconFolder = get_bloginfo('wpurl')."/wp-content/plugins/ufave/images";

	}
	
	else
	{
		$inFeed=false;
		
		$widgetTitle = $ufaveWidgetTitle;
		$feedBurnerID = $ufaveFeedBurnerID;
		$feedBurnerAddress = "";
		$moreLink = $ufaveMoreLink;
		$hideBrand = $ufaveHideBrand;
		$centerFade = $ufaveCenterFade;
		$docType = $ufaveDocType;
		$feedURL = $ufaveFeedURL;
		$iconFolder = $ufaveIconDir;
	}


		
	$title=urldecode($title);
	$url=urldecode($url);
	
	
	$enctitle=urlencode($title);
	$encurl=urlencode($url);

	
	if($docType=="HTML")
	{
		$endTag="";
	}
	else
	{
		$endTag="/";
	}

	// Begin ufave Widget
	if($listView==1 || $ufaveButton==1)
		$d.="";
	else
		$d="<div class='ufave'><a name='ufave'></a>";

	
	if($ufaveButton==1)	
	{
		$d.="<a title='Bookmark or Share This Page ...' href='".$url."#ufave' onclick='document.getElementById(\"ufaveMore".$ufaveCount."\").style.display=\"block\"; return false;' rel='nofollow'><img src='$iconFolder/ufaveus.png' $endTag></a>";	
	}
	

	
	
	if(($moreLink & !$inFeed) | ($ufaveButton==1 & !$inFeed))
	{
		if(!$ufaveMoreStyleWritten)
		{
			
			$d.="<link rel='stylesheet' type='text/css' href='$iconFolder/more.css' $endTag>";
			$ufaveMoreStyleWritten=true;
		}
		
		if($centerFade)	
		{
			
			$d.="<div class='ufaveMore' id='ufaveMore".$ufaveCount."'>";
			$d.="<div class='ufaveMoreWindow' style='position:relative;top:2%;margin:auto;opacity:1;'>";
		}
		else
		{
			
			$d.="<div class='ufaveMoreWindow' id='ufaveMore".$ufaveCount."' style='display:none;position:absolute;'>";
		}
		
		
		$d.="<div class='ufaveMoreWindowHeader'>";
		$d.="<a rel='nofollow' href='".$url."#ufave' onclick='document.getElementById(\"ufaveMore".$ufaveCount."\").style.display=\"none\"; return false;'>$closeThisWindow<span class='ufaveCloseIcon' style='background-image: url($iconFolder/imagecol.png); background-position:0px -1037px;'>&nbsp;</span></a>"; 
		$d.="$bookmarkAndShare ";
		$d.="</div>";
		
		
		$d.="<div class='ufaveSaveToBrowser'>";
		$d.="<a rel='nofollow' href='".$url."#ufave' onclick='javascript:if(document.all){window.external.AddFavorite(\"$url\", \"$title\");} else if(window.sidebar){window.sidebar.addPanel(\"$title\", \"$url\", \"\");}return false;' style='background-image: url($iconFolder/imagecol.png); background-position:0px -986px;'>$ufaveSaveToBrowserFavorites</a>"; 
		$d.="</div>";

				
		$d.="<div class='ufaveSiteLinks'>";
		$d.="<table cellspacing='3'><tr><td>";
		$linkX=0;
		$colLimit=ceil((count($ufaveLinks)-1)/5);	
		foreach($ufaveLinks as $link)
		{
			
			if($link[0]=="Email")
				continue;
		
			
			if($linkX == $colLimit)
			{
				$d.="</td><td>";
				$linkX=1;
			}
			else
				$linkX++;
	
			
			if($link[5]==0)
			{
				$d.= "<div class='ufaveSiteLink'>"
						."<a onclick='target=\"".$ufaveLinkTarget."\";' href='".$link[2]."' title='".$link[1]."' rel='nofollow' style='background-image: url($iconFolder/imagecol.png); background-position:0px -".$link[4]."px'>"
						.$link[0]."</a></div>";
			}
			else if($link[5]==1)
			{
				$d.= "<div class='ufaveSiteLink' style='margin-left:-20px !important;'>".$link[6]."</div>";
			}
	
		}
		$d.="</td></tr></table>";
		$d.="</div>";

		
		$d.="<div class='ufaveEmail'>";
		$d.="<a rel='nofollow' href='http://www.feedburner.com/fb/a/emailFlare?loc=$loc&amp;itemTitle=$title&amp;uri=$url' style='background-image: url($iconFolder/imagecol.png); background-position:0px -1003px;'>$emailThisToAFriend</a>"; 
		$d.="</div>";


			
		

		
		
	
		
		$d.="<div class='ufavePoweredBy'><a href='http://www.ufave.us/' rel='dofollow'>$poweredBy ufave&trade;</a></div>";

		$d.="</div>"; 

		if($centerFade)	
		{
			
			$d.="<div class='ufaveFadeBackground'></div>";
			$d.="</div>"; 
		}

	}
	
	if($ufaveButton==0)	
	{
			
		if($listView==1)
			$d.="<ul>";
		else
			$d.="<div class='linkbuttons'>";	
			
		foreach($ufaveLinks as $link)
		{
			
			$linkKey=str_replace(".", "", str_replace(" ", "", $link[0]));
			
					
			if($inBlog)
			{
				if($useDefaults)
				{
					if(strpos($ufaveSelectedLinks,$link[0])===false)
						$linkOn=0;
					else
						$linkOn=1;
				}
				else
					$linkOn=get_option('ufave_Include'.$linkKey);
			}
			
			else
			{
				if(strpos($ufaveSelectedLinks,$link[0])===false)
					$linkOn=0;
				else
					$linkOn=1;
			}
	
			
			if($linkOn==1)
			{
				if($listView==1)
				{
					$d.="<li>";
					$d.= "<a style='padding-left:20px; padding-bottom:5px; background:url(\"".$iconFolder."/".$link[3]."\") no-repeat;' href='".$link[2]."' title='".$link[1]."' onclick='target=\"".$ufaveLinkTarget."\";' rel='nofollow'>";
					if($listView==1)
						$d.="".$link[0];
					$d.= "</a> ";
					$d.="</li>";
				}
				
				else
				{
					$d.= "<a href='".$link[2]."' title='".$link[1]."' onclick='target=\"".$ufaveLinkTarget."\";' rel='nofollow'>"
							. "<img src='".$iconFolder."/".$link[3]."' style='width:16px; height:16px;' alt='[".$link[0]."] ' $endTag>"
							. "</a> ";
				}
			}
		}
	
		
		if($moreLink)
		{
			if($listView==1)
				$d.="<li>";
	
			if($inFeed)
				$d.=" <a title='Bookmark or share this page ...' href='".$url."#ufave' rel='nofollow'><small><img src=/wp-content/plugins/ufave/images/favebutton.png></small></a>";
			else
				$d.=" <a title='Bookmark or share this page ...' href='".$url."#ufave' onclick='document.getElementById(\"ufaveMore".$ufaveCount."\").style.display=\"block\"; return false;' rel='nofollow'><small><img src=/wp-content/plugins/ufave/images/favebutton.png></small></a>";
	
			if($listView==1)
				$d.="</li>";
		}
	
		if($listView==1)
			$d.="</ul>";
		else
			$d.="</div>";	
	

	
	}

	if($listView!=1 & $ufaveButton!=1)
		$d.="</div>"; 
	
	return $d;
}


 
function writeufaveMoreStyle()
{
	global $ufaveDocType;
	global $ufaveIconDir;
	global $ufaveMoreStyleWritten;
	
	if(function_exists('get_option'))
	{
		$docType = get_option('ufave_DocType');
		$iconFolder = get_bloginfo('wpurl')."/wp-content/plugins/ufave/images";
	}
	else
	{
		$docType = $ufaveDocType;
		$iconFolder= $ufaveIconDir;
	}


	
	if($ufaveMoreStyleWritten)
		return;

	if($ufaveDocType=="HTML")
	{
		echo "<link rel='stylesheet' type='text/css' href='$iconFolder/more.css'>";
	}
	else
	{
		echo "<link rel='stylesheet' type='text/css' href='$iconFolder/more.css' />";
	}

	$ufaveMoreStyleWritten=true;

}


function ufaveIt($title, $url, $inBlog=false)
{
	global $ufaveListView;
	$ufaveListView=0;
	echo createufave($title, $url, $inBlog);
}

function ufaveItList($title, $url, $inBlog=false)
{
	global $ufaveListView;
	$ufaveListView=1;
	echo createufave($title, $url, $inBlog);
}

function ufaveItButton($title, $url, $inBlog=false)
{
	global $ufaveButton;
	$ufaveButton=1;
	echo createufave($title, $url, $inBlog);
}


function getufaveLinks($t, $u, $loc)
{
/**
  www.uFave.us Social Bookmarking Widget
**/

	$i=0;
	
	$links[$i++] = array("Ask", "Save to Ask", "http://myjeeves.ask.com/mysearch/BookmarkIt?v=1.2&amp;t=webpages&amp;url=$u&amp;title=$t", "ask.png", 0, 0);
	$links[$i++] = array("backflip", "Save to backflip", "http://www.backflip.com/add_page_pop.ihtml?url=$u&amp;title=$t", "backflip.png", 17, 0);
	$links[$i++] = array("blinklist", "Save to blinklist", "http://blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=$u&amp;Title=$t", "blinklist.png", 34, 0);
	$links[$i++] = array("BlogBookmark", "Save to BlogBookmark", "http://www.blogbookmark.com/submit.php?url=$u", "blogbookmark.png", 51, 0);
	$links[$i++] = array("Bloglines", "Save to Bloglines", "http://www.bloglines.com/sub/$u", "bloglines.png", 68, 0);
	$links[$i++] = array("BlogMarks", "Save to BlogMarks", "http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=$u&amp;title=$t", "blogmarks.png", 85, 0);
	$links[$i++] = array("Blogsvine", "Save to Blogsvine", "http://www.blogsvine.com/submit.php?url=$u", "blogsvine.png", 102, 0);
	$links[$i++] = array("BuddyMarks", "BuddyMark It", "http://www.buddymarks.com/add_bookmark.php?bookmark_title=$t&amp;bookmark_url=$u", "buddymarks.png", 119, 0);
	$links[$i++] = array("BallHype!", "Save to BallHype!", "http://ballhype.com/post/url/?url=$u&amp;title=$t", "ballhype.png", 136, 0);
	$links[$i++] = array("CiteULike", "Save to CiteULike", "http://www.citeulike.org/posturl?url=$u&amp;title=$t", "citeulike.png", 153, 0);
	$links[$i++] = array("co.mments", "Save to co.mments.com", "http://co.mments.com/track?url=$u&amp;title=$t", "comments.png", 170, 0);
	$links[$i++] = array("Connotea", "Save to Connotea", "http://www.connotea.org/addpopup?continue=confirm&amp;uri=$u&amp;title=$t", "connotea.png", 187, 0);
	$links[$i++] = array("del.icio.us", "Save to del.icio.us", "http://del.icio.us/post?url=$u&amp;title=$t", "delicious.png", 204, 0);
	$links[$i++] = array("Digg", "Digg It!", "http://digg.com/submit?phase=2&amp;url=$u&amp;title=$t", "digg.png", 221, 0);
	$links[$i++] = array("diigo", "Save to diigo", "http://www.diigo.com/post?url=$u&amp;title=$t", "diigo.png", 238, 0);
	$links[$i++] = array("DotNetKicks", "Save to DotNetKicks", "http://www.dotnetkicks.com/kick/?url=$u&amp;title=$t", "dotnetkicks.png", 255, 0);
	$links[$i++] = array("De.lirio.us", "Save to De.lirio.us", "http://de.lirio.us/rubric/post?uri=$u", "delirious.png", 272, 0);
	$links[$i++] = array("dzone", "Save to dzone", "http://www.dzone.com/links/add.html?description=$t&amp;url=$u&amp;title=$t", "dzone.png", 289, 0);
	$links[$i++] = array("Facebook", "Save to Facebook", "http://www.facebook.com/share.php?u=$u", "facebook.png", 306, 0);
	$links[$i++] = array("Fark", "FarkIt!", "http://cgi.fark.com/cgi/fark/farkit.pl?u=$u&amp;h=$t", "fark.png", 323, 0);
	$links[$i++] = array("Faves", "Save to Faves", "http://faves.com/Authoring.aspx?u=$u&amp;t=$t", "faves.png", 340, 0);
	$links[$i++] = array("Feed Me Links", "Save to Feed Me Links", "http://feedmelinks.com/categorize?from=toolbar&amp;op=submit&amp;name=$t&amp;url=$u", "feedmelinks.png", 357, 0);
	$links[$i++] = array("Friendsite", "Save to Friendsite", "http://friendsite.com/users/bookmark/?u=$u&amp;t=$t", "friendsite.png", 391, 0);
	$links[$i++] = array("folkd.com", "Save to folkd.com", "http://www.folkd.com/submit/$u", "folkd.png", 374, 0);
	$links[$i++] = array("Furl", "Save to Furl", "http://www.furl.net/storeIt.jsp?u=$u&amp;t=$t", "furl.png", 408, 0);
	$links[$i++] = array("Google", "Save to Google Bookmarks", "http://www.google.com/bookmarks/mark?op=edit&amp;output=popup&amp;bkmk=$u&amp;title=$t", "google.png", 425, 0);
	$links[$i++] = array("Hugg", "Save to Hugg", "http://www.hugg.com/node/add/storylink?edit[title]=$t&amp;edit[url]=$u", "hugg.png", 442, 0);
	$links[$i++] = array("Jamespot", "Spot It!", "http://www.jamespot.com/?action=spotit&url=$u", "jamespot.png", 1122, 0);
	$links[$i++] = array("Jeqq", "Save to Jeqq", "http://www.jeqq.com/submit.php?url==$u&amp;title=$t", "jeqq.png", 459, 0);
	$links[$i++] = array("Kaboodle", "Save to Kaboodle", "http://www.kaboodle.com/za/selectpage?p_pop=false&amp;pa=url&amp;u=$u", "kaboodle.png", 476, 0);
	$links[$i++] = array("kirtsy", "Save to kirtsy", "http://www.kirtsy.com/submit.php?url=$u", "kirtsy.png", 493, 0);
	$links[$i++] = array("link-a-Gogo", "Save to link-a-Gogo", "http://www.linkagogo.com/go/AddNoPopup?url=$u&amp;title=$t", "linkagogo.png", 510, 0);
	$links[$i++] = array("LinkedIn", "Share on LinkedIn", "http://www.linkedin.com/shareArticle?mini=true&url=$u&title=$t", "linkedin.png", 1155, 0);
	$links[$i++] = array("LinksMarker", "Save to LinksMarker", "http://www.linksmarker.com/submit.php?url=$u&amp;title=$t", "linksmarker.png", 527, 0);
	$links[$i++] = array("Ma.gnolia", "Save to Ma.gnolia", "http://ma.gnolia.com/bookmarklet/add?url=$u&amp;title=$t", "magnolia.png", 544, 0);
	$links[$i++] = array("Mister Wong", "Save to Mister Wong", "http://www.mister-wong.com/index.php?action=addurl&amp;bm_url=$u&amp;bm_description=$t", "misterwong.png", 561, 0);
	$links[$i++] = array("Mixx", "Save to Mixx", "http://www.mixx.com/submit?page_url=$u", "mixx.png", 578, 0);
	$links[$i++] = array("MySpace", "Save to MySpace", "http://www.myspace.com/Modules/PostTo/Pages/?c=$u&amp;t=$t", "myspace.png", 595, 0);
	$links[$i++] = array("MyWeb", "Save to My Web", "http://myweb.yahoo.com/myweb/save?t=$t&amp;u=$u", "myweb.png", 612, 0);
	$links[$i++] = array("Netvouz", "Save to Netvouz", "http://www.netvouz.com/action/submitBookmark?url=$u&amp;title=$t&amp;popup=no", "netvouz.png", 629, 0);
	$links[$i++] = array("Newsvine", "Seed Newsvine", "http://www.newsvine.com/_tools/seed?popoff=0&amp;u=$u", "newsvine.png", 646, 0);
	$links[$i++] = array("oneview", "Save to oneview", "http://www.oneview.com/quickadd/neu/addBookmark.jsf?URL=$u&amp;title=$t", "oneview.png", 1054, 0);
	$links[$i++] = array("OnlyWire", "Save to OnlyWire", "http://www.onlywire.com/submit?u=$u&amp;t=$t", "onlywire.png", 1071, 0);
	$links[$i++] = array("PlugIM", "Promote on PlugIM", "http://www.plugim.com/submit?url=$u&amp;title=$t", "plugim.png", 663, 0);
	$links[$i++] = array("Propeller", "Submit to Propeller", "http://www.propeller.com/submit/?U=$u&amp;T=$t", "propeller.png", 697, 0);
	$links[$i++] = array("Reddit", "Reddit", "http://reddit.com/submit?url=$u&amp;title=$t", "reddit.png", 714, 0);
	$links[$i++] = array("Rojo", "Save to Rojo", "http://www.rojo.com/add-subscription/?resource=$u", "rojo.png", 731, 0);
	$links[$i++] = array("Segnalo", "Save to Segnalo", "http://segnalo.com/post.html.php?url=$u&amp;title=$t", "segnalo.png", 748, 0);
	$links[$i++] = array("Shoutwire", "Shout It!", "http://www.shoutwire.com/?p=submit&amp;link=$u", "shoutwire.png", 765, 0);
	$links[$i++] = array("Simpy", "Save to Simpy", "http://www.simpy.com/simpy/LinkAdd.do?href=$u&amp;title=$t", "simpy.png", 782, 0);
	$links[$i++] = array("Slashdot", "Slashdot It!", "http://slashdot.org/bookmark.pl?url=$u&amp;title=$t", "slashdot.png", 799, 0);
	$links[$i++] = array("Sphere", "Sphere It", "http://www.sphere.com/search?q=sphereit:$u&amp;title=$t", "sphere.png", 816, 0);
	$links[$i++] = array("Sphinn", "Sphinn", "http://sphinn.com/submit.php?url=$u&amp;title=$t", "sphinn.png", 833, 0);
	$links[$i++] = array("Spurl", "Save to Spurl", "http://www.spurl.net/spurl.php?url=$u&amp;title=$t", "spurl.png", 850, 0);
	$links[$i++] = array("Squidoo", "Save to Squidoo", "http://www.squidoo.com/lensmaster/bookmark?$u", "squidoo.png", 867, 0);
	$links[$i++] = array("StumbleUpon", "Stumble It!", "http://www.stumbleupon.com/submit?url=$u&amp;title=$t", "stumbleupon.png", 884, 0);
	$links[$i++] = array("Technorati", "Add to my Technorati Favorites", "http://technorati.com/faves?add=$u", "technorati.png", 901, 0);
	$links[$i++] = array("ThisNext", "Save to ThisNext", "http://www.thisnext.com/pick/new/submit/sociable/?url=$u&amp;name=$t", "thisnext.png", 918, 0);
	$links[$i++] = array("Twitter", "Save to Twitter", "http://twitter.com/home/?status=$t+$u", "twitter.png", 1105, 0);
	$links[$i++] = array("Webride", "Discuss on Webride", "http://webride.org/discuss/split.php?uri=$u&amp;title=$t", "webride.png", 935, 0);
	$links[$i++] = array("Windows Live", "Save to Windows Live", "https://favorites.live.com/quickadd.aspx?mkt=en-us&amp;url=$u&amp;title=$t", "windowslive.png", 952, 0);
	$links[$i++] = array("Worlds Movies", "Save to Worlds Movies", "http://www.worldsmovies.net/member/uservideo.php?url=$u", "worldsmovies.png", 1139, 0);
	$links[$i++] = array("Yahoo!", "Save to Yahoo! Bookmarks", "http://bookmarks.yahoo.com/toolbar/savebm?opener=tb&amp;u=$u&amp;t=$t", "yahoo.png", 969, 0);

 	$links[$i++] = array("Buzz", "Buzz Up!", "http://buzz.yahoo.com/submit", "buzz.png", 1088, 1, "<script>yahooBuzzArticleHeadline='$t';</script><script type='text/javascript' src='http://d.yimg.com/ds/badge2.js' badgetype='text'></script>");

	$links[$i++] = array("Email", "Email this to a friend", "http://www.feedburner.com/fb/a/emailFlare?itemTitle=$t&amp;uri=$u&amp;loc=$loc", "email.png", 1003, 0);

	return $links;	
}


function ufavePost($content)
{
	
	global $doing_rss;
	global $ufaveListView;
	global $ufaveHide;

	$ufaveListView=0;

	
	if(strpos($content, '[no-ufave]') > 0 || $ufaveHide)
		return $content;

	$excludeFromFeed = get_option('ufave_ExcludeFromFeed');

	if($excludeFromFeed & (is_feed() || $doing_rss))
		return $content;
	
	$location = get_option('ufave_Location');
	
	if($location=="toc")
		return createufave(the_title('','',false), get_permalink(), true) . $content;
	else if($location=="boc")
		return $content . createufave(the_title('','',false), get_permalink(), true);
	else if($location=="other")
		return $content;

}

// Admin
function ufaveOptionsPage()
{
	$ufaveLinks=getufaveLinks('','','');

	if(isset($_POST['ufaveUpdate']))
	{
		// Options
		$widgetTitle = $_POST['WidgetTitle'];
		$location = $_POST['Location'];
		$moreLink = $_POST['MoreLink']=="1" ? "1" : "0";
		$centerFade = $_POST['CenterFade']=="1" ? "1" : "0";
		$feedBurnerID = $_POST['FeedBurnerID'];
		$feedBurnerAddress = $_POST['FeedBurnerAddress'];
		$hideBrand = $_POST['HideBrand']=="1" ? "1" : "0";
		$excludeFromFeed = $_POST['ExcludeFromFeed']=="1" ? "1" : "0";
		$docType = $_POST['DocType'];
		
		update_option('ufave_WidgetTitle', $widgetTitle);
		update_option('ufave_Location', $location);
		
		foreach($ufaveLinks as $link)
		{
			$linkKey=str_replace(".", "", str_replace(" ", "", $link[0]));
			$linkOn=$_POST['Include'.$linkKey]=="1" ? "1" : "0";
			update_option('ufave_Include'.$linkKey, $linkOn);
		}

		
		update_option('ufave_CenterFade', $centerFade);
		update_option('ufave_FeedBurnerID', $feedBurnerID);
		update_option('ufave_FeedBurnerAddress', $feedBurnerAddress);
		update_option('ufave_HideBrand', $hideBrand);
		update_option('ufave_ExcludeFromFeed', $excludeFromFeed);
		update_option('ufave_DocType', $docType);
		update_option('ufave_IsSetup', "1");
		
?>

<div class="updated fade" id="message" style="background-color:rgb(207, 235, 247);"><p><strong>Options saved.</strong></p></div>
<?php
	}
	else
	{
		
		$widgetTitle = get_option('ufave_WidgetTitle');
		$location = get_option('ufave_Location');
		$centerFade = get_option('ufave_CenterFade');
		$feedBurnerID = get_option('ufave_FeedBurnerID');
		$feedBurnerAddress = get_option('ufave_FeedBurnerAddress');
		$hideBrand = get_option('ufave_HideBrand');
		$excludeFromFeed= get_option('ufave_ExcludeFromFeed');
		$docType = get_option('ufave_DocType');
	}

	if($feedBurnerAddress=="")
		$feedURL=get_bloginfo_rss('rss2_url');
	else
		$feedURL="http://feeds.feedburner.com/".$feedBurnerAddress;

?>
	<div class="wrap">
		<h2>ufave</h2>
		<form method="POST">
			<table class="optiontable">
				<tr valign="top">
					<th width="316">&nbsp;</th>
				  <td width="400">&nbsp;</td>
				</tr>
				<tr valign="top">
					<th>Widget Location:</th>
					<td>
						<select id="Location" name="Location">
							<option value="boc" <?php echo $location=="boc" ? "selected" : ""; ?>>Bottom of Content</option>
							<option value="toc" <?php echo $location=="toc" ? "selected" : ""; ?>>Top of Content</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th>&nbsp;</th>
				  <td>&nbsp;</td>
				</tr>
				<tr valign="top">
					<th>&nbsp;</th>
					<td>&nbsp;
					
					</td>
				</tr>
				<tr valign="top">
					<th>Drop-down or center of the page ? </th>
				  <td>
					<input name="CenterFade" type="checkbox" id="CenterFade" value="1" checked <?php echo $centerFade ? 'checked' : ''; ?>> 
					Check	this	if	you	want Center of the page </td>
				</tr>
			</table>
			<p class="submit"><input name="ufaveUpdate" type="submit" value="Update Options &raquo;"></p>
		</form>
		<h3>&nbsp;</h3>
		
	</div>
	<div class="wrap">
		<h2>About:</h2>
		<p>Check for the latest information  here:  <a href="http://www.ufave.us">http://www.ufave.us</a></p>
		<p>&nbsp;</p>
	</div>
<?php
}


function ufaveAdminSetup()
{
	add_options_page('ufave', 'ufave', 8, basename(__FILE__), 'ufaveOptionsPage');	
}


function ufavePostNOT($excerpt)
{
	return $excerpt;
}


if(function_exists('add_action'))
{
	add_action('admin_menu', 'ufaveAdminSetup');
	add_action('wp_head', 'writeufaveMoreStyle');
}

if(function_exists('add_filter'))
{
	add_filter('the_content', 'ufavePost');
	add_filter('the_excerpt', 'ufavePostNOT');
}

?>