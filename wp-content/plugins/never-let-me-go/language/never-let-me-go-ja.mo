Þ    3      ´  G   L      h  	   i     s  F   |     Ã  $   Ý  	     T        a     h     w               §     °  9   ¸  h   ò  8   [          ¨     Â  ·   Ù  ²     h   D  X   ­  )   	     0	  +   G	     s	     	  
   	     ¥	     ¬	  1   ½	     ï	     	
     
     %
  
   4
     ?
  v   Ì
     C  D   Ø  y                  ±  &   :  .   a  8     +   É     õ          4  W   D  $     6   Á     ø  ]        r     y          ·     Ó     ã     ó  L         M  i   å     O     i  *       °  3  ¿     ó  f     <   î  *   +  0   V            !   ³     Õ     Ü  [   é  *   E  !   p          ¢     ¯  Ì   ¼  Á     ð   K     <     Ç     d     s       0   #  6   T  W     *   ã               2              !                              #   &   %                )   3                     -         ,       	   (   +                                 *          "           /   1   .                '                 $   
          0    %% found. Advanced All of your data on our service will be deleted and can't be restored. Allow user to self delete Are you sure to delete your account? Assign to But in most cases, you might want personal data like email or address to be deleted. Delete Delete Account Delete from database Deleted User Destroy Level Disabled Enabled For example, you can delete user_meta &quot;address&quot; For this purpose, action hook is available. Write the code below in your theme's <em>functions.php</em>. Furthermore, You can call action hook for other plugins. Here is an example: How to create Resign Page How to treat user data If you choose "%1$s", all data related to the user will be deleted.<br /> If not, the user account will be replaced to unavailabe account and whole data will be kept in your database. If you choose <strong>%s</strong>, You can assign resigning user's contents to particular user. i.e. in CGM site, assigning resigning's contents to the pseudo user(deleted user). If you choose some resign page to publicly display, you can make show messag before resigning and after. In case you choose <strong>"%s"</strong>, Your user's data will remain on your database. Input user name or e-mail to find user ID Make credential hashed Make user account unavailable and keep data Never Let Me Go setting No resign page No results Normal Nothing changed. Now you get user_id and manage data how you like. Option failed to updated. Option updated. Resign Page Resign Setting Resign Way Resign page means the static page which have form to resign. <br />If not specified, user can delete himself on profile page of admin panel. Split assigned page's content with &lt;!--nextpage--&gt;.<br /> 1st page will be shown before resigning and 2nd after. This Plugin allows your user to delete his/her own account. If you want, you can also display somehow painfull thank-you message on his resignation. This function are executed when user delete himself with this plugin To delete related information, see description below.<br />Please be carefull with your country's low on other's privacy. User ID User id to delete User information will be changed when user delete his own account.<br />If you don't want this, you can keep infomration by select "%s". We miss you and hope to see you again. You are about to resign from our web magazine. You can delete your account by putting the button below. Your account has been deleted successfully. Project-Id-Version: Never Let Me Go
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2012-04-03 17:24+0900
PO-Revision-Date: 2012-04-03 17:28+0900
Last-Translator: Takahashi Fumiki <info@takahashifumiki.com>
Language-Team: Hametuha inc. <info@hametuha.co.jp>
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Poedit-KeywordsList: _;gettext;gettext_noop;e
X-Poedit-Basepath: .
X-Poedit-SourceCharset: utf-8
X-Poedit-Language: Japanese
X-Poedit-Country: JAPAN
X-Poedit-SearchPath-0: .
X-Poedit-SearchPath-1: ..
 %%ä»¶ãè¦ã¤ããã¾ãã ä¸ç´èåã ããªãã®ãã¼ã¿ã¯ãã¹ã¦åé¤ãããåã«æ»ããã¨ã¯ã§ãã¾ããã ã¦ã¼ã¶ã¼ã«éä¼ãè¨±å¯ãã ã¢ã«ã¦ã³ããåé¤ãã¦ããããã§ããï¼ å¥ã¦ã¼ã¶ã¼ã¸ã®å²å½ ããããã¡ã¼ã«ã¢ãã¬ã¹ãä½æç­ã®åäººæå ±ã¯åé¤ãããã§ãããã åé¤ ã¢ã«ã¦ã³ããåé¤ãã ãã¼ã¿ãã¼ã¹ããåé¤ åé¤ãããã¦ã¼ã¶ã¼ åé¤ã¬ãã« è¨±å¯ããªã è¨±å¯ãã ãã¨ãã°ã&quot;address&quot;ã¨ããuser_metaãåé¤ã§ãã¾ãã ãã®ããã«ã¢ã¯ã·ã§ã³ããã¯ãå©ç¨å¯è½ã§ããä»¥ä¸ã®ã³ã¼ãããã¼ãåã®<em>functions.php</em>ã«è¨è¼ãã¦ãã ããã ãããä»ã®ãã©ã°ã¤ã³ã®ããã«ã¢ã¯ã·ã§ã³ããã¯ãå¼ã³åºããã¨ãã§ãã¾ãã ä»¥ä¸ã¯ãã®ä¾ã§ã: éä¼ãã¼ã¸ã®ä½ãæ¹ ã¦ã¼ã¶ã¼ãã¼ã¿ã®åãæ±ãæ¹æ³ "%1$s"ãé¸ãã å ´åããã®ã¦ã¼ã¶ã¼ã«è©²å½ãããã¹ã¦ã®ãã¼ã¿ã¯åé¤ããã¾ãã<br />æå®ããªãã£ãå ´åãã¦ã¼ã¶ã¼ã¢ã«ã¦ã³ãã¯ç¡å¹ãªãã®ã«ç½®ãæãããããã¹ã¦ã®ãã¼ã¿ããã¼ã¿ãã¼ã¹ã«æ®ãã¾ãã <strong>%s</strong>ãé¸ã¶ã¨ãéä¼ããã¦ã¼ã¶ã¼ã®ã³ã³ãã³ããç¹å®ã®ã¦ã¼ã¶ã¼ã«å²ãå½ã¦ããã¾ããä¾ï¼CGMãµã¤ãã«ããã¦ãéä¼ããã¦ã¼ã¶ã¼ã®ã³ã³ãã³ããä»®ã®ã¦ã¼ã¶ã¼ï¼åé¤ãããã¦ã¼ã¶ã¼ã¨ããååã®ã¦ã¼ã¶ã¼ï¼ã«å²ãå½ã¦ã ç®¡çç»é¢ä»¥å¤ã§è¡¨ç¤ºããéä¼ãã¼ã¸ãä½æããã¨ãéä¼åã¨éä¼å¾ã«ã¡ãã»ã¼ã¸ãè¡¨ç¤ºãããã¨ãã§ãã¾ãã <strong>"%s"</strong>ãé¸ãã å ´åãã¦ã¼ã¶ã¼ãã¼ã¿ã¯ãã¼ã¿ãã¼ã¹ã«æ®ãã¾ãã ã¦ã¼ã¶ã¼åãã¡ã¼ã«ã¢ãã¬ã¹ãå¥åãã¦æ¤ç´¢ ã­ã°ã¤ã³æå ±ãããã·ã¥åãã ã¢ã«ã¦ã³ããåæ­¢ãããã¼ã¿ãæ®ã Never Let Me Goè¨­å® éä¼ãã¼ã¸ãªã è¦ã¤ããã¾ããã§ããã éå¸¸ å¤æ´ãªã ããã§user_idãåå¾ã§ããã®ã§ãå¥½ããªããã«ãã¼ã¿ãç®¡çã§ãã¾ã è¨­å®ãæ´æ°ã§ãã¾ããã§ããã è¨­å®ã¯æ´æ°ããã¾ããã éä¼ãã¼ã¸ éä¼è¨­å® éä¼æ¹æ³ éä¼ãã¼ã¸ã¨ã¯éä¼ç¨ãã©ã¼ã ãæã¤éçãã¼ã¸ã®ãã¨ã§ãã<br />æå®ããªãå ´åãã¦ã¼ã¶ã¼ã¯ç®¡çç»é¢ã®ãã­ãã£ã¼ã«ãã¼ã¸ããã®ã¿éä¼ã§ãã¾ãã å²ãå½ã¦ããããã¼ã¸ã®ã³ã³ãã³ãã&lt;!--nextpage--&gt;ã§åå²ãã¦ãã ããã<br />æåã®ãã¼ã¸ãéä¼åã«ã2ãã¼ã¸ç®ãéä¼å¾ã«è¡¨ç¤ºããã¾ãã ãã®ãã©ã°ã¤ã³ã¯ã¦ã¼ã¶ã¼ãèªåã®ã¢ã«ã¦ã³ããåé¤ã§ããããã«ãã¾ããå¿è¦ãªãã°ãã¦ã¼ã¶ã¼ãéä¼ããã¨ãã«æ²ããããªãµã³ã­ã¥ã¼ã¡ãã»ã¼ã¸ãè¡¨ç¤ºãããã¨ãã§ãã¾ãã ãã®é¢æ°ã¯ã¦ã¼ã¶ã¼ããã®ãã©ã°ã¤ã³ãå©ç¨ãã¦ã¢ã«ã¦ã³ããåé¤ãããã¨ããã¨ãã«å®è¡ããã¾ãã æå ±ãåé¤ããã«ã¯ããã®ãã¼ã¸ä¸é¨ãåèã«ãã¦ãã ããã<br />åäººæå ±ä¿è­·ã«é¢ããæ³å¾ã«æ³¨æãã¦ãã ããã ã¦ã¼ã¶ã¼ID åé¤ããã¦ã¼ã¶ã¼ID ã¦ã¼ã¶ã¼æå ±ã¯ã¢ã«ã¦ã³ããåæ­¢ããã¨ãã«åé¤ããã¾ãã<br />ããããããªãå ´åã¯"%s"ãé¸ãã§ãã ããã ã¾ãã®ãå©ç¨ããå¾ã¡ãã¦ãã¾ãã Webãã¬ã¸ã³ãéä¼ãããã¨ãã¦ãã¾ãã ä¸ã®ãã¿ã³ãæ¼ããã¨ã§ã¢ã«ã¦ã³ããåé¤ãããã¨ãã§ãã¾ãã ã¢ã«ã¦ã³ãã¯åé¤ããã¾ããã 