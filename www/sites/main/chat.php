<div id="content">   
  <div id="ContentHeaderLeft"><h5><?= SYSNAME ?></h5></div>
  <div id="ContentHeaderCenter"></div>
  <div id="ContentHeaderRight"><h5><? echo $webui_chat; ?></h5></div>  

  <div id="info">
    <p><? echo $webui_chat_info; ?> Basic IRC chat help <a href="http://www.ircbeginner.com/ircinfo/ircc-commands.html" target="_blank">here</a>.</p>
  </div>
  
  <div class="clear"></div>
    <div id="chat">
      <iframe class="level1" 
              src="http://webchat.freenode.net/?channels=<?=$support_IRC_channel?>&uio=MTE9MjI2dd" 
              width="100%" 
              height="400" 
              border="0" 
              frameborder="0" 
              framespacing="0"
              allowTransparency="true"
              style="z-index:0">
      </iframe>
    </div>
</div>
