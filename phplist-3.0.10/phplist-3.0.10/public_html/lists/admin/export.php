<?php
require_once dirname(__FILE__).'/accesscheck.php';

# export users from PHPlist

include dirname(__FILE__) .'/date.php';

$fromdate = '';
$todate = '';
$from = new date("from");
$to = new date("to");
if (isset($_REQUEST['list'])) {
  if (isset($_GET['list'])) {
    $list = sprintf('%d',$_GET['list']);
  } elseif (isset($_POST['column']) && $_POST['column'] == 'listentered') {
    $list = sprintf('%d',$_POST['list']);
  } else {
    $list = 0;
  }
} else {
  $list = 0;
}

$access = accessLevel('export');
switch ($access) {
  case 'owner':
    $querytables = $GLOBALS['tables']['list'].' list ,'.$GLOBALS['tables']['user'].' user ,'.$GLOBALS['tables']['listuser'].' listuser ';
    $subselect = ' and listuser.listid = list.id and listuser.userid = user.id and list.owner = ' . $_SESSION['logindetails']['id'];
    $listselect_where = ' where owner = ' . $_SESSION['logindetails']['id'];
    $listselect_and = ' and owner = ' . $_SESSION['logindetails']['id'];
    break;
  case 'all':
    if ($list) {
      $querytables = $GLOBALS['tables']['user'].' user'.', '.$GLOBALS['tables']['listuser'].' listuser';
      $subselect = ' and listuser.userid = user.id ';
    } else {
      $querytables = $GLOBALS['tables']['user'].' user';
      $subselect = '';
    }
    $listselect_where = '';
    $listselect_and = '';
    break;
  case 'none':
  default:
    $querytables = $GLOBALS['tables']['user'].' user';
    $subselect = ' and user.id = 0';
    $listselect_where = ' where owner = 0';
    $listselect_and = ' and owner = 0';
    break;
}

require dirname(__FILE__). '/structure.php';
if (isset($_POST['processexport'])) {
  if (!verifyToken()) { ## csrf check
    print Error($GLOBALS['I18N']->get('Invalid security token. Please reload the page and try again.'));
    return;
  }
  $_SESSION['export'] = array();
  $_SESSION['export']['column'] = $_POST['column'];
  $_SESSION['export']['cols'] = $_POST['cols'];
  $_SESSION['export']['attrs'] = $_POST['attrs'];
  $_SESSION['export']['fromdate'] = $from->getDate("from");
  $_SESSION['export']['todate'] =  $to->getDate("to");
  $_SESSION['export']['list'] = $list;
  
  print '<p>'.s('Processing export, this may take a while. Please wait').'</p>';
  print $GLOBALS['img_busy'];
  print '<div id="progresscount" style="width: 200; height: 50;">Progress</div>';
  print '<br/> <iframe id="export" src="./?page=pageaction&action=export&ajaxed=true'.addCsrfGetToken().'" scrolling="no" height="50"></iframe>';
  return;
}

if ($list) {
  print sprintf($GLOBALS['I18N']->get('Export subscribers on %s'),ListName($list));
}

print formStart();
?>

<?php echo $GLOBALS['I18N']->get('What date needs to be used:');?><br/>
<input type="radio" name="column" value="nodate" /> <?php echo $GLOBALS['I18N']->get('Any date');?><br/>
<input type="radio" name="column" value="entered" checked="checked" /> <?php echo $GLOBALS['I18N']->get('When they signed up');?><br/>
<input type="radio" name="column" value="modified" /> <?php echo $GLOBALS['I18N']->get('When the record was changed');?><br/>
<input type="radio" name="column" value="historyentry" /> <?php echo $GLOBALS['I18N']->get('Based on changelog');?><br/>
<input type="radio" name="column" value="listentered" /> <?php echo $GLOBALS['I18N']->get('When they subscribed to');?> 


<?php
if (empty($list)) { 
  print '<select name="list">';
  $req = Sql_Query(sprintf('select * from %s %s',$GLOBALS['tables']['list'],$listselect_where));
  while ($row = Sql_Fetch_Array($req)) {
    printf ('<option value="%d">%s</option>',$row['id'],$row['name']);
  }
  print '</select>';
} else {
  printf('<input type="hidden" name="list" value="%d" />',$list);
  print '<strong>'.listName($list).'</strong><br/><br/>';
}
?>
<div id="exportdates">
<?php echo $GLOBALS['I18N']->get('Date From:');?> <?php echo $from->showInput("","",$fromdate);?>
<?php echo $GLOBALS['I18N']->get('Date To:');?>  <?php echo $to->showInput("","",$todate);?>
</div>


<?php echo $GLOBALS['I18N']->get('Select the columns to include in the export');?>

<?php
  $cols = array();
  while (list ($key,$val) = each ($DBstruct["user"])) {
    if (strpos($val[1],"sys") === false) {
      printf ("\n".'<br/><input type="checkbox" name="cols[]" value="%s" checked="checked" /> %s ',$key,$val[1]);
    } elseif (preg_match("/sysexp:(.*)/",$val[1],$regs)) {
      printf ("\n".'<br/><input type="checkbox" name="cols[]" value="%s" checked="checked" /> %s ',$key,$regs[1]);
    }
  }
  $res = Sql_Query("select id,name,tablename,type from {$tables['attribute']} order by listorder");
  $attributes = array();
  while ($row = Sql_fetch_array($res)) {
    printf ("\n".'<br/><input type="checkbox" name="attrs[]" value="%s" checked="checked" /> %s ',$row["id"],stripslashes(htmlspecialchars($row["name"])));
  }

?>

<p class="submit"><input type="submit" name="processexport" id="processexport" value="<?php echo $GLOBALS['I18N']->get('Export'); ?>"></p></form>

