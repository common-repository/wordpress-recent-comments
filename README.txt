=== Wordpress Recent Comments ===
Contributors: Bharath
Donate link: http://111waystomakemoney.com/donate
Tags: comments, widget, sidebar, AJAX, option,admin, plugin, footer, links, copyright, administration, blog,Google Adsense, WordPress,Plugin,widget,post,plugin,admin,sidebar,comments,images,twitter,page,google,links,image,ad,admin,administration,ads,adsense,advertising,affiliate,AJAX,amazon,analytics,anti-spam,api,archive,atom,audio,authentication,author,automatic,Avatar,blog,blogroll,book,bookmark,bookmarking,bookmarks,buddypress,button,calendar,captcha,categories,category,cms,code,comment,comments,community,contact,content,counter,CSS,custom,dashboard,database,date,del.icio.us,delicious,Digg,edit,editor,email,embed,event,events,excerpt,Facebook,feed,feeds,filter,flash,flickr,form,Formatting,gallery,google,google,maps,html,image,images,integration,iphone,javascript,jquery,language,lightbox,link,links,list,login,mail,manage,maps,media,menu,meta,mobile,mp3,music,myspace,navigation,News,nofollow,notification,page,pages,password,paypal,performance,permalink,photo,photos,php,picture,pictures,plugin,plugins,Post,posts,profile,quotes,random,Reddit,redirect,register,registration,related,rss,scroll,search,security,seo,Share,sharing,shortcode,sidebar,simple,slideshow,social,social,bookmarking,social,media,spam,statistics,stats,Style,tag,tags,technorati,template,text,theme,themes,thumbnail,time,TinyMCE,title,tracking,tweet,twitter,update,upload,url,user,users,video,widget,widgets,wordpress,wpmu,xml,yahoo,youtube
Requires at least: 2.5
Tested up to: 3.0
Stable tag: 4.15.01

Display recent comments in your blog sidebar.

== Description ==

Show the recent comments in your WordPress sidebar. You can limit the number of comments, set the maximum length of excerpts, filter out pingbacks/trackbacks. You can also enable or disable the avatars, resize and reposition them. Besides above, it supports WordPress Widget. And now, it's AJAX paged comments, you can turn to the newer or older comments when you clicked on the paging buttons.

For detailed description of the plugin visit plugin page at[Wordpress recent comments](http://111waystomakemoney.com/wordpress-recent-comments/).

**Features:**

* Support for East Asian characters
* Avatar support
* Widget support
* AJAX paged comment
* Expend comment contents
* Separating pingbacks/trackbacks from comments
* Support 'Show smilies as graphic icons' option
* Filter quotes
* Support jQuery lib
* SEO friendly

**Supported Languages:**

* US English/en_US (default)
* 简体中文/zh_CN ([Bharath](http://111waystomakemoney.com/))
* Albanian/sq_AL ([Romeo Shuka](http://www.romeolab.com/))
* Arabic/ar (Mustafa)
* Belorussian/by_BY (Marcis Gasuns)
* Bulgarian/bg_BG ([Emil Minev](http://www.inspirelearning.net/))
* Czech/cs_CZ (Ladislav Prskavec)
* Danish/da_DK ([Morten L. Johansen](http://www.lystorp.com/))
* Dutch/nl_NL ([Jan Willem Wilmsen](http://directic.nl/))
* Finnish/fi (C. Hellberg)
* Français/fr_FR (Luc Santeramo)
* German/de_DE ([Sylvia Egger](http://sprungmarker.de/))
* Hungarian/hu_HU (János Csárdi-Braunstein)
* Israel Hebrew/he_IL ([Roy Azrad](http://www.lawtech.co.il/))
* Italian/it_IT (Enrico Flaminios)
* Lithuania/lt_LT ([Mantas Malcius](http://mantas.malcius.lt/))
* Macedonian/mk_MK ([Dimitar Talevski](http://www.solipamet.com/))
* Persian/fa_IR ([Farzad Sagharchi](http://blog.sagharchi.ir/))
* Polish/pl_PL ([Chris Ostrowski](http://www.kierunek-sukces.pl/))
* Russian/ru_RU ([Алексей В.Ч.](http://www.alexnote.ru/))
* Spanish/es_ES (Eugenio Cavero)
* Swedish/sv_SE (Jonas Nordström)
* Türkçe/tr_TR ([Hamdi Kellecioglu](http://www.tirnakmakasi.com/))
* Ukrainian/uk ([Jurko Chervony](http://pavonine.com.ua/cat/themes/))

**Demo:**
demo [Wordpress recent comments](http://111waystomakemoney.com/wordpress-recent-comments/).

Warm Regards,
Bharath
 [Wordpress recent comments](http://111waystomakemoney.com/wordpress-recent-comments/).

== Installation ==

1. Unzip archive to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. (Optional) Go to 'Settings->Wordpress-Recent-Comments' to change the options.
4. This is two ways to add the Wordpress-Recent-Comments widget to the sidebar:
    * Go to 'Design->Widgets' and add the Wordpress-Recent-Comments to your blog.
    * In your 'sidebar.php' file add the following lines:
****

    <h3>Recent Comments</h3>
    <ul><?php wp_recentcomments(); ?></ul>

**Custom CSS:**

* Wordpress-Recent-Comments will load Wordpress-Recent-Comments.css from your theme directory if it exists.
* If it doesn't exists, it will load the default style that comes with Wordpress-Recent-Comments.

== Screenshots ==

1. Recent comments on sidebar.
2. options of Wordpress-Recent-Comments plugin.

== Frequently Asked Questions ==
For any other questions on the plugin visit plugin page at[Wordpress recent comments](http://111waystomakemoney.com/wordpress-recent-comments/).
= That's why it's 'loading...' and never show comment list? =

1. Check footer.php file of your theme, if you cannot find `<?php wp_footer(); ?>`, please add `<?php wp_footer(); ?>` before `</body>`.
2. (If that's okay with step 1, ignore this.) Check the plugin settings on 'Settings -> Wordpress-Recent-Comments', and reset JavaScript Lib to 1st or 2nd item.

= Comments are messed up after update plugin? =

1. Select 'Use Wordpress-Recent-Comments.css' in 'Settings -> Wordpress-Recent-Comments' page.
2. (If that's okay with step 1, ignore this.) Remove Wordpress-Recent-Comments.css file in theme directory if it exists.

== Changelog ==

****

    VERSION DATE       TYPE   CHANGES
    4.15.01   2010/10/15 NEW    Initial release.
                       
    4.15.01   2010/10/09 FIX    Compatible with IE7 & IE8.
                       