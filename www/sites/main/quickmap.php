<? 
  include("quickmap/includes/config.php");
  include("quickmap/languages/translator.php");

  $dbort = $CONF_db_server;
  $dbuser = $CONF_db_user;
  $dbpw = $CONF_db_pass;
  $dbdb = $CONF_db_database;

  $grid_x = 0;
  $grid_y = 0;

  if (isset($_POST['x']) && ($_POST['y']))
  {
  $grid_x = $_POST['x'];
  $grid_y = $_POST['y'];
  }
  else
  {
  if (isset($_GET['x']) && ($_GET['y']))
  {
  $grid_x = $_GET['x'];
  $grid_y = $_GET['y'];
  } 
  }

  if ($grid_x == 0) {$grid_x = $CONF_center_coord_x;}
  if ($grid_y == 0) {$grid_y = $CONF_center_coord_y;}
  if ($grid_y <= 30) {$grid_y = "100";}
  if ($grid_x <= 30) {$grid_x = "100";}
  if ($grid_x >=99999) {$grid_x = $CONF_center_coord_x;}
  if ($grid_y >=99999) {$grid_y = $CONF_center_coord_y;}

  $start_x = $grid_x - 20;
  $start_y = $grid_y + 10;

  $end_x = $grid_x + 20;
  $end_y = $grid_y - 10;

  mysql_connect($dbort,$dbuser,$dbpw); 
  mysql_select_db($dbdb); 
  $z=mysql_query("SELECT RegionUUID,RegionName,LocX,LocY FROM gridregions");
  
  $xx=0;
  while($region=mysql_fetch_array($z))
  {
      $work_reg = $region[RegionUUID].";".$region[RegionName].";".$region[LocX].";".$region[LocY];
      $region_sg[$xx] = $work_reg;
      $xx++;
  } 
?>


<div id="content">
<div id="ContentHeaderLeft"><h5><?= SYSNAME ?>: <? echo $webui_world_map ?></h5></div>
  <div id="ContentHeaderCenter"></div>
  <div id="ContentHeaderRight">
    <h5><a <?= "onclick=\"window.open('".SYSURL."quickmap/index.php','mywindow')\"" ?> style="float:right; display:inline-block;"><? echo $webui_fullscreen; ?></a></h5>
  </div>

  <div id="region_quickmap">
  
  <div id="topright1">
    <form name="submit" action="index.php?page=quickmap" method="post">
      <!-- <div id=map-coord-text style="z-index: 1;"><? // echo $CONF_txt_coords;?></div> -->
      <div id="roundedcoord"></div>
        <div id="map-coord-x" style="z-index: 1;">X: </div><div id=map-coord-x-input style="z-index: 1;"><input type="text" title="Entrer coordonnees X" value="<?print $grid_x;?>" name="x" size="4" /></div>
        <div id="map-coord-y" style="z-index: 1;">Y: </div><div id=map-coord-y-input style="z-index: 1;"><input type="text" title="Entrer coordonnees Y" value="<?print $grid_y;?>"  name="y" size="4" /></div>
      <div id="map-coord-button" style="z-index: 1;"><input type="submit" class="submit" name="Submit" value="" title="Rafraichir" /></div>
    </form>
  </div>

  <div id="map-nav"> <!-- <? // echo $CONF_txt_nav;?> -->
  <div id="map-nav-up" style="z-index: 1;">
    <a href="index.php?page=quickmap&x=<? echo $grid_x;?>&y=<? echo $grid_y + 10; ?>" target="_self">
      <img src="<?=SYSURL?>quickmap/images/pan_up.png" border="0" alt="<? echo $CONF_txt_north;?>" title="<? echo $CONF_txt_north;?>" />
    </a>
  </div>
  
  <div id="map-nav-down" style="z-index: 1;">
    <a href="index.php?page=quickmap&x=<? print $grid_x; ?>&y=<? print $grid_y -10; ?>" target="_self">
      <img src="<?=SYSURL?>quickmap/images/pan_down.png" border="0" alt="<? echo $CONF_txt_south;?>" title="<? echo $CONF_txt_south;?>" />
    </a>
  </div>
  
  <div id="map-nav-left" style="z-index: 1;">
    <a href="index.php?page=quickmap&x=<? print $grid_x - 10; ?>&y=<? print $grid_y; ?>" target="_self">
      <img src="<?=SYSURL?>quickmap/images/pan_left.png" border="0" alt="<? echo $CONF_txt_west;?>" title="<? echo $CONF_txt_west;?>" />
    </a>
    
  </div>
  
  <div id="map-nav-right" style="z-index: 1;">
    <a href="index.php?page=quickmap&x=<? print $grid_x + 10; ?>&y=<? print $grid_y; ?>" target="_self">
      <img src="<?=SYSURL?>quickmap/images/pan_right.png" border="0" alt="<? echo $CONF_txt_east;?>" title="<? echo $CONF_txt_east;?>" />
    </a>
  </div>
  
  <div id="map-nav-center" style="z-index: 1;">
    <a href="index.php?page=quickmap&x=<? echo $CONF_center_coord_x;?>&y=<? echo $CONF_center_coord_y;?>" target="_self">
      <img src="<?=SYSURL?>quickmap/images/center.png" border="0" alt="<? echo $CONF_txt_center;?>" title="<? echo $CONF_txt_center;?>" />
    </a>
  </div>
</div>


<div class="center2">
<table>
<?
  $y = $start_y;
  $x = $start_x;

  while ($y >= $end_y)
    {
       $x = $start_x;
       ?>
       <tr valign="middle">
       
       <td valign="middle">
       <div class="styleCoords">
       <?
       if ($y <> $start_y)
           {
            echo $y;
           }
       ?>
       </div>
       <?
         while ($x <= $end_x)
         {
         if ($y == $start_y)
          {
          ?>
          </td>
          
          <td align="center"><div class="styleCoords">
          <?
            $xs="a";
            $xs=$x;
            $z1=""; $z2=""; $z3=""; $z4=""; $z5=""; $z6="";
            $z1= substr($xs,'0','1');
            $z2= substr($xs,'1','1');
            $z3= substr($xs,'2','1');
            $z4= substr($xs,'3','1');
            $z5= substr($xs,'4','1');
            $z6= substr($xs,'5','1');

            if (z1) {print $z1;}
            if (z2) {print $z2;}
            if (z3) {print "<br />".$z3;}
            if (z4) {print $z4;}
            if (z5) {print "<br />".$z5;}
            if (z6) {print $z6;}

          ?>
          </div>
          <? $x++; }
          
          else
          {
            $count = count($region_sg);
            for ($q = 0; $q < $count; $q++)
            {
              $region_value = $region_sg[$q];
              $sim_new = 0;
              list($region_uuid, $region_name, $region_locx, $region_locy) = explode(";",$region_value);

              if ($region_locx >= 100000)
              {
                $region_locx = $region_locx / 256;
                $region_locy = $region_locy / 256;
              }

              if (($region_locx == $x) && ($region_locy == $y))
              {$sim_new = 1; break;}
            }

 
            if (($x == $CONF_center_coord_x) && ($y == $CONF_center_coord_y)) { ?>
            </td>
             
             <td>
                <a style="cursor:pointer" onClick="window.open('quickmap/modules/show_region.php?region=<?print $region_uuid; ?>','mywindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=950,height=600')">
                  <img src="<?=SYSURL?>quickmap/images/grid_mainland.jpg" alt="Region=<? print $region_name; ?> | X=<?print $x; ?> | Y=<?print $y; ?> | Status: <? echo $CONF_txt_occupied;?>" title="Region=<? print $region_name; ?> | X=<?print $x; ?> | Y=<?print $y; ?> | Status: <? echo $CONF_txt_occupied;?>" /></a>
                <? $x++; }
              else { if ($sim_new == 1) { ?>
              
              </td>
              
              <td>
                <a style="cursor:pointer" onClick="window.open('quickmap/modules/show_region.php?region=<?print $region_uuid; ?>','mywindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=950,height=600')">
                <img src="<?=SYSURL?>quickmap/images/grid_occupied.jpg" alt="Region=<? print $region_name; ?> | X=<?print $x; ?> | Y=<?print $y; ?> | Status: occupied" title="Region=<? print $region_name; ?> | X=<?print $x; ?> | Y=<?print $y; ?> | Status: occupied" /></a>
                <? $x++; }
              
                else { ?>
              </td>
              
              <td>
                <img src="<?=SYSURL?>quickmap/images/grid_free.jpg" alt= "X=<?print $x; ?> | Y=<?print $y; ?> | Status: <? echo $CONF_txt_free;?>" title="X=<?print $x; ?> | Y=<?print $y; ?> | Status: <? echo $CONF_txt_free;?>" />
                <? $x++; }}}}
                $y--; } ?>
          </td>
    </tr>
</table>

</div></div></div>
