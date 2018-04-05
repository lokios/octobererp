<?php /* Smarty version 2.6.26, created on 2018-01-27 03:32:58
         compiled from prepare.tpl */ ?>
<?php if (! $this->_tpl_vars['REPORTICO_AJAX_CALLED']): ?>
<?php if (! $this->_tpl_vars['EMBEDDED_REPORT']): ?>
<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE><?php echo $this->_tpl_vars['TITLE']; ?>
</TITLE>
<LINK id="reportico_css" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['STYLESHEET']; ?>
">
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
<LINK id="bootstrap_css" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['JSPATH']; ?>
/bootstrap2/css/bootstrap.min.css">
<?php else: ?>
<LINK id="bootstrap_css" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['JSPATH']; ?>
/bootstrap3/css/bootstrap.min.css">
<?php endif; ?>
<?php endif; ?>
<?php echo $this->_tpl_vars['OUTPUT_ENCODING']; ?>

</HEAD>
<BODY class="swPrpBody">
<?php else: ?>
<LINK id="reportico_css" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['STYLESHEET']; ?>
">
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<?php if (! $this->_tpl_vars['REPORTICO_BOOTSTRAP_PRELOADED']): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
<LINK id="bootstrap_css" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['JSPATH']; ?>
/bootstrap2/css/bootstrap.min.css">
<?php else: ?>
<LINK id="bootstrap_css" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['JSPATH']; ?>
/bootstrap3/css/bootstrap.min.css">
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>

<?php echo '
<!--[if IE]>
<style type="text/css">
    .swPrpTextField
    {
        width: 350px;
    }
</style>
<![endif]-->
'; ?>


<?php if ($this->_tpl_vars['AJAX_ENABLED']): ?>
<?php if (! $this->_tpl_vars['REPORTICO_AJAX_PRELOADED']): ?>
<?php if (! $this->_tpl_vars['REPORTICO_JQUERY_PRELOADED']): ?>
<?php echo '
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/jquery.js"></script>
'; ?>

<?php endif; ?>
<?php echo '
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/ui/jquery-ui.js"></script>
'; ?>

<?php echo '
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/download.js"></script>
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/reportico.js"></script>
'; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['REPORTICO_CSRF_TOKEN']): ?>
<script type="text/javascript">var ajax_event_handler = "<?php echo $this->_tpl_vars['REPORTICO_AJAX_HANDLER']; ?>
";</script>
<script type="text/javascript">var reportico_csrf_token = "<?php echo $this->_tpl_vars['REPORTICO_CSRF_TOKEN']; ?>
";</script>
<?php endif; ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<?php if (! $this->_tpl_vars['REPORTICO_BOOTSTRAP_PRELOADED']): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JSPATH']; ?>
/bootstrap2/js/bootstrap.min.js"></script>
<?php else: ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JSPATH']; ?>
/bootstrap3/js/bootstrap.min.js"></script>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php if (! $this->_tpl_vars['REPORTICO_AJAX_PRELOADED']): ?>
<?php echo '
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/ui/i18n/jquery.ui.datepicker-'; ?>
<?php echo $this->_tpl_vars['AJAX_DATEPICKER_LANGUAGE']; ?>
<?php echo '.js"></script>
'; ?>

<?php endif; ?>
<?php if (! $this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<?php echo '
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/jquery.jdMenu.js"></script>
<LINK id="reportico_css" REL="stylesheet" TYPE="text/css" HREF="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/jquery.jdMenu.css">
'; ?>

<?php endif; ?>
<?php echo '
<LINK id="reportico_css" REL="stylesheet" TYPE="text/css" HREF="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/ui/jquery-ui.css">
<script type="text/javascript">var reportico_this_script = "'; ?>
<?php echo $this->_tpl_vars['SCRIPT_SELF']; ?>
<?php echo '";</script>
<script type="text/javascript">var reportico_ajax_script = "'; ?>
<?php echo $this->_tpl_vars['REPORTICO_AJAX_RUNNER']; ?>
<?php echo '";</script>
'; ?>

<?php if ($this->_tpl_vars['REPORTICO_BOOTSTRAP_MODAL']): ?>
<script type="text/javascript">var reportico_bootstrap_styles = "<?php echo $this->_tpl_vars['BOOTSTRAP_STYLES']; ?>
";</script>
<script type="text/javascript">var reportico_bootstrap_modal = true;</script>
<?php else: ?>
<script type="text/javascript">var reportico_bootstrap_modal = false;</script>
<script type="text/javascript">var reportico_bootstrap_styles = false;</script>
<?php endif; ?>

<?php if ($this->_tpl_vars['REPORTICO_DYNAMIC_GRIDS']): ?>
<script type="text/javascript">var reportico_dynamic_grids = true;</script>
<?php if ($this->_tpl_vars['REPORTICO_DYNAMIC_GRIDS_SORTABLE']): ?>
<script type="text/javascript">var reportico_dynamic_grids_sortable = true;</script>
<?php else: ?>
<script type="text/javascript">var reportico_dynamic_grids_sortable = false;</script>
<?php endif; ?>
<?php if ($this->_tpl_vars['REPORTICO_DYNAMIC_GRIDS_SEARCHABLE']): ?>
<script type="text/javascript">var reportico_dynamic_grids_searchable = true;</script>
<?php else: ?>
<script type="text/javascript">var reportico_dynamic_grids_searchable = false;</script>
<?php endif; ?>
<?php if ($this->_tpl_vars['REPORTICO_DYNAMIC_GRIDS_PAGING']): ?>
<script type="text/javascript">var reportico_dynamic_grids_paging = true;</script>
<?php else: ?>
<script type="text/javascript">var reportico_dynamic_grids_paging = false;</script>
<?php endif; ?>
<script type="text/javascript">var reportico_dynamic_grids_page_size = <?php echo $this->_tpl_vars['REPORTICO_DYNAMIC_GRIDS_PAGE_SIZE']; ?>
;</script>
<?php else: ?>
<script type="text/javascript">var reportico_dynamic_grids = false;</script>
<?php endif; ?>
<?php endif; ?>
<?php if (! $this->_tpl_vars['REPORTICO_AJAX_PRELOADED']): ?>
<?php echo '
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/select2/js/reporticoSelect2.min.js"></script>
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/jquery.dataTables.js"></script>
'; ?>

<LINK id="PRP_StyleSheet_s2" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['JSPATH']; ?>
/select2/css/reporticoSelect2.min.css">
<LINK id="PRP_StyleSheet_dt" REL="stylesheet" TYPE="text/css" HREF="<?php echo $this->_tpl_vars['STYLESHEETDIR']; ?>
/jquery.dataTables.css">
<?php endif; ?>
<?php if ($this->_tpl_vars['REPORTICO_CHARTING_ENGINE'] == 'NVD3'): ?>
<?php if (! $this->_tpl_vars['REPORTICO_AJAX_PRELOADED']): ?>
<?php echo '
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/nvd3/d3.min.js"></script>
<script type="text/javascript" src="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/nvd3/nv.d3.js"></script>
<LINK id="bootstrap_css" REL="stylesheet" TYPE="text/css" HREF="'; ?>
<?php echo $this->_tpl_vars['JSPATH']; ?>
<?php echo '/nvd3/nv.d3.css">
'; ?>

<?php endif; ?>
<?php endif; ?>
<div id="reportico_container">
    <script>
        reportico_criteria_items = [];
<?php if (isset ( $this->_tpl_vars['CRITERIA_ITEMS'] )): ?>
<?php unset($this->_sections['critno']);
$this->_sections['critno']['name'] = 'critno';
$this->_sections['critno']['loop'] = is_array($_loop=$this->_tpl_vars['CRITERIA_ITEMS']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['critno']['show'] = true;
$this->_sections['critno']['max'] = $this->_sections['critno']['loop'];
$this->_sections['critno']['step'] = 1;
$this->_sections['critno']['start'] = $this->_sections['critno']['step'] > 0 ? 0 : $this->_sections['critno']['loop']-1;
if ($this->_sections['critno']['show']) {
    $this->_sections['critno']['total'] = $this->_sections['critno']['loop'];
    if ($this->_sections['critno']['total'] == 0)
        $this->_sections['critno']['show'] = false;
} else
    $this->_sections['critno']['total'] = 0;
if ($this->_sections['critno']['show']):

            for ($this->_sections['critno']['index'] = $this->_sections['critno']['start'], $this->_sections['critno']['iteration'] = 1;
                 $this->_sections['critno']['iteration'] <= $this->_sections['critno']['total'];
                 $this->_sections['critno']['index'] += $this->_sections['critno']['step'], $this->_sections['critno']['iteration']++):
$this->_sections['critno']['rownum'] = $this->_sections['critno']['iteration'];
$this->_sections['critno']['index_prev'] = $this->_sections['critno']['index'] - $this->_sections['critno']['step'];
$this->_sections['critno']['index_next'] = $this->_sections['critno']['index'] + $this->_sections['critno']['step'];
$this->_sections['critno']['first']      = ($this->_sections['critno']['iteration'] == 1);
$this->_sections['critno']['last']       = ($this->_sections['critno']['iteration'] == $this->_sections['critno']['total']);
?>
        reportico_criteria_items.push("<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['name']; ?>
");
<?php endfor; endif; ?>
<?php endif; ?>
    </script>


<script type="text/javascript">var reportico_pdf_delivery_mode = "<?php echo $this->_tpl_vars['PDF_DELIVERY_MODE']; ?>
";</script>
<script type="text/javascript">var reportico_datepicker_language = "<?php echo $this->_tpl_vars['AJAX_DATEPICKER_FORMAT']; ?>
";</script>
<script type="text/javascript">var reportico_ajax_mode = "<?php echo $this->_tpl_vars['REPORTICO_AJAX_MODE']; ?>
";</script>
<FORM class="swPrpForm" id="criteriaform" name="topmenu" method="POST" action="<?php echo $this->_tpl_vars['SCRIPT_SELF']; ?>
">
<input type="hidden" name="reportico_session_name" value="<?php echo $this->_tpl_vars['SESSION_ID']; ?>
" />

<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2' || $this->_tpl_vars['BOOTSTRAP_STYLES'] == '3' || $this->_tpl_vars['BOOTSTRAP_STYLES'] == 'joomla3'): ?>
<!-- BOOTSTRAP VERSION -->
<?php if ($this->_tpl_vars['SHOW_HIDE_NAVIGATION_MENU'] == 'show' || $this->_tpl_vars['SHOW_HIDE_DROPDOWN_MENU'] == 'show'): ?>
    <div class="navbar navbar-default reportico-navbar" role="navigation">
<?php else: ?>
    <div style="display:none" class="navbar navbar-default reportico-navbar" role="navigation">
<?php endif; ?>
        <div class="container-fluid">
            <div class="navbar-header reportico-navbar-header">
                <!--button type="button" class="icon-bars menu-toggle-icon navbar-toggle collapsed" data-toggle="collapse" data-target="#reportico-bootstrap-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button-->
<?php if ($this->_tpl_vars['SHOW_HIDE_DROPDOWN_MENU'] == 'show' && $this->_tpl_vars['DROPDOWN_MENU_ITEMS']): ?>
            <!--a style="display:inline-block" href="#" class="navbar-brand reportico-dropdown-brand"><?php echo $this->_tpl_vars['MENU_TITLE']; ?>
 :</a-->
<?php endif; ?>
            </div>

            <div class= "collapse navbar-collapse"  style="display: inline-block !important" id="reportico-bootstrap-collapse" >
                <ul class="nav navbar-nav" style="display: inline-block">
                    <li class="dropdown nav-item reportico-dropdown-listitem">
                        <a style="display:inline-block" href="#" class="navbar-brand reportico-dropdown-brand"><?php echo $this->_tpl_vars['MENU_TITLE']; ?>
 :</a>
                    </li>
<?php if ($this->_tpl_vars['SHOW_HIDE_DROPDOWN_MENU'] == 'show' && $this->_tpl_vars['DROPDOWN_MENU_ITEMS']): ?>
<?php unset($this->_sections['menu']);
$this->_sections['menu']['name'] = 'menu';
$this->_sections['menu']['loop'] = is_array($_loop=$this->_tpl_vars['DROPDOWN_MENU_ITEMS']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['menu']['show'] = true;
$this->_sections['menu']['max'] = $this->_sections['menu']['loop'];
$this->_sections['menu']['step'] = 1;
$this->_sections['menu']['start'] = $this->_sections['menu']['step'] > 0 ? 0 : $this->_sections['menu']['loop']-1;
if ($this->_sections['menu']['show']) {
    $this->_sections['menu']['total'] = $this->_sections['menu']['loop'];
    if ($this->_sections['menu']['total'] == 0)
        $this->_sections['menu']['show'] = false;
} else
    $this->_sections['menu']['total'] = 0;
if ($this->_sections['menu']['show']):

            for ($this->_sections['menu']['index'] = $this->_sections['menu']['start'], $this->_sections['menu']['iteration'] = 1;
                 $this->_sections['menu']['iteration'] <= $this->_sections['menu']['total'];
                 $this->_sections['menu']['index'] += $this->_sections['menu']['step'], $this->_sections['menu']['iteration']++):
$this->_sections['menu']['rownum'] = $this->_sections['menu']['iteration'];
$this->_sections['menu']['index_prev'] = $this->_sections['menu']['index'] - $this->_sections['menu']['step'];
$this->_sections['menu']['index_next'] = $this->_sections['menu']['index'] + $this->_sections['menu']['step'];
$this->_sections['menu']['first']      = ($this->_sections['menu']['iteration'] == 1);
$this->_sections['menu']['last']       = ($this->_sections['menu']['iteration'] == $this->_sections['menu']['total']);
?>
                    <li class="dropdown nav-item reportico-dropdown-listitem"><a class="dropdown-toggle nav-link reportico-dropdown-link" data-toggle="dropdown" href="#"><?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['title']; ?>
<span class="caret"></span></a>
                    <ul class="dropdown-menu reportico-dropdown">
<?php unset($this->_sections['menuitem']);
$this->_sections['menuitem']['name'] = 'menuitem';
$this->_sections['menuitem']['loop'] = is_array($_loop=$this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['menuitem']['show'] = true;
$this->_sections['menuitem']['max'] = $this->_sections['menuitem']['loop'];
$this->_sections['menuitem']['step'] = 1;
$this->_sections['menuitem']['start'] = $this->_sections['menuitem']['step'] > 0 ? 0 : $this->_sections['menuitem']['loop']-1;
if ($this->_sections['menuitem']['show']) {
    $this->_sections['menuitem']['total'] = $this->_sections['menuitem']['loop'];
    if ($this->_sections['menuitem']['total'] == 0)
        $this->_sections['menuitem']['show'] = false;
} else
    $this->_sections['menuitem']['total'] = 0;
if ($this->_sections['menuitem']['show']):

            for ($this->_sections['menuitem']['index'] = $this->_sections['menuitem']['start'], $this->_sections['menuitem']['iteration'] = 1;
                 $this->_sections['menuitem']['iteration'] <= $this->_sections['menuitem']['total'];
                 $this->_sections['menuitem']['index'] += $this->_sections['menuitem']['step'], $this->_sections['menuitem']['iteration']++):
$this->_sections['menuitem']['rownum'] = $this->_sections['menuitem']['iteration'];
$this->_sections['menuitem']['index_prev'] = $this->_sections['menuitem']['index'] - $this->_sections['menuitem']['step'];
$this->_sections['menuitem']['index_next'] = $this->_sections['menuitem']['index'] + $this->_sections['menuitem']['step'];
$this->_sections['menuitem']['first']      = ($this->_sections['menuitem']['iteration'] == 1);
$this->_sections['menuitem']['last']       = ($this->_sections['menuitem']['iteration'] == $this->_sections['menuitem']['total']);
?>
<?php if (isset ( $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items'][$this->_sections['menuitem']['index']]['reportname'] )): ?>
                        <li ><a class="dropdown-item reportico-dropdown-item" href="<?php echo $this->_tpl_vars['RUN_REPORT_URL']; ?>
&project=<?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items'][$this->_sections['menuitem']['index']]['project']; ?>
&xmlin=<?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items'][$this->_sections['menuitem']['index']]['reportfile']; ?>
"><?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items'][$this->_sections['menuitem']['index']]['reportname']; ?>
</a></li>
<?php endif; ?>
<?php endfor; endif; ?>
                    </ul>
                    </li>
<?php endfor; endif; ?>
<?php endif; ?>
                </ul>
            </div>
            <div class= "collapse navbar-collapse pull-right"  style="display: inline-block" id="reportico-bootstrap-collapse2" >
<?php if ($this->_tpl_vars['SHOW_HIDE_NAVIGATION_MENU'] == 'show'): ?>
                <ul style="display:inline-block" class= "nav navbar-nav pull-right navbar-right">
<?php else: ?>
                <ul style="display:none" class= "nav navbar-nav pull-right navbar-right">
<?php endif; ?>
                <li style="display: inline-block"> <input type="submit" style="width: 0px; color: transparent; background-color: transparent; border-color: transparent; cursor: default;" class="prepareAjaxExecute" id="prepareAjaxExecute" name="submitPrepare" value=""> </li>
<?php if ($this->_tpl_vars['SHOW_TOPMENU']): ?>
<?php if (( $this->_tpl_vars['SHOW_DESIGN_BUTTON'] )): ?>
                <li style="display: inline-block"><input class="span <?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_ADMIN_BUTTON']; ?>
swAdminButton2" type="submit" name="submit_design_mode" value="<?php echo $this->_tpl_vars['T_DESIGN_REPORT']; ?>
"></li>
<?php endif; ?>
<?php if ($this->_tpl_vars['OUTPUT_SHOW_DEBUG']): ?>
<?php if ($this->_tpl_vars['SHOW_DESIGN_BUTTON']): ?>
                <li style="display: inline-block">
                <div style="margin: 6px 8px 0px 8px">
                <?php echo $this->_tpl_vars['T_DEBUG_LEVEL']; ?>

                <SELECT class="span2 <?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_DROPDOWN']; ?>
" style="margin-bottom: 1px; display:inline; width: auto" name="debug_mode">';
                    <OPTION <?php echo $this->_tpl_vars['DEBUG_NONE']; ?>
 label="None" value="0"><?php echo $this->_tpl_vars['T_DEBUG_NONE']; ?>
</OPTION>
                    <OPTION <?php echo $this->_tpl_vars['DEBUG_LOW']; ?>
 label="Low" value="1"><?php echo $this->_tpl_vars['T_DEBUG_LOW']; ?>
</OPTION>
                    <OPTION <?php echo $this->_tpl_vars['DEBUG_MEDIUM']; ?>
 label="Medium" value="2"><?php echo $this->_tpl_vars['T_DEBUG_MEDIUM']; ?>
</OPTION>
                    <OPTION <?php echo $this->_tpl_vars['DEBUG_HIGH']; ?>
 label="High" value="3"><?php echo $this->_tpl_vars['T_DEBUG_HIGH']; ?>
</OPTION>
                </SELECT>
                </div>
                </li>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_LOGIN']): ?>
<?php if (strlen ( $this->_tpl_vars['PROJ_PASSWORD_ERROR'] ) > 0): ?>
                                <div style="color: #ff0000;"><?php echo $this->_tpl_vars['T_PASSWORD_ERROR']; ?>
</div>
<?php endif; ?>
            <li style="display:inline-block">
				<div style="inline-block; margin-top: 6px"><?php echo $this->_tpl_vars['T_ENTER_PROJECT_PASSWORD']; ?>
<input type="password" name="project_password" value="">
				<input class="span2 swAdminButton" type="submit" name="login" value="<?php echo $this->_tpl_vars['T_LOGIN']; ?>
">
                </div>
			</li>
<?php endif; ?>
<?php endif; ?>
<?php if (( $this->_tpl_vars['SHOW_ADMIN_BUTTON'] )): ?>
<?php if (strlen ( $this->_tpl_vars['ADMIN_MENU_URL'] ) > 0): ?> 
              <li class="nav-item" style="display:inline-block">
                    <a class="nav-link swAdminButton2 reportico-dropdown-link" href="<?php echo $this->_tpl_vars['ADMIN_MENU_URL']; ?>
"><?php echo $this->_tpl_vars['T_ADMIN_MENU']; ?>
</a>
              </li>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_PROJECT_MENU_BUTTON']): ?>
              <li class="nav-item" style="display: inline-block">
                    <a class="nav-link swAdminButton2 reportico-dropdown-link" href="<?php echo $this->_tpl_vars['MAIN_MENU_URL']; ?>
"><?php echo $this->_tpl_vars['T_PROJECT_MENU']; ?>
</a>
              </li>
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_LOGOUT']): ?>
                <li style="display: inline-block"> <input class="span <?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_ADMIN_BUTTON']; ?>
swAdminButton2" type="submit" name="logout" value="<?php echo $this->_tpl_vars['T_LOGOFF']; ?>
"></li>
<?php endif; ?>
</div>
</ul>
        </div>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
        </div>
<?php endif; ?>
</div>

<!-- BOOTSTRAP VERSION -->
<?php endif; ?> 

<?php else: ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_DROPDOWN_MENU'] == 'show' && $this->_tpl_vars['DROPDOWN_MENU_ITEMS']): ?>
<ul id="dropmenu" class="jd_menu" style="clear: none;float: left;width: 100%; ">
<?php unset($this->_sections['menu']);
$this->_sections['menu']['name'] = 'menu';
$this->_sections['menu']['loop'] = is_array($_loop=$this->_tpl_vars['DROPDOWN_MENU_ITEMS']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['menu']['show'] = true;
$this->_sections['menu']['max'] = $this->_sections['menu']['loop'];
$this->_sections['menu']['step'] = 1;
$this->_sections['menu']['start'] = $this->_sections['menu']['step'] > 0 ? 0 : $this->_sections['menu']['loop']-1;
if ($this->_sections['menu']['show']) {
    $this->_sections['menu']['total'] = $this->_sections['menu']['loop'];
    if ($this->_sections['menu']['total'] == 0)
        $this->_sections['menu']['show'] = false;
} else
    $this->_sections['menu']['total'] = 0;
if ($this->_sections['menu']['show']):

            for ($this->_sections['menu']['index'] = $this->_sections['menu']['start'], $this->_sections['menu']['iteration'] = 1;
                 $this->_sections['menu']['iteration'] <= $this->_sections['menu']['total'];
                 $this->_sections['menu']['index'] += $this->_sections['menu']['step'], $this->_sections['menu']['iteration']++):
$this->_sections['menu']['rownum'] = $this->_sections['menu']['iteration'];
$this->_sections['menu']['index_prev'] = $this->_sections['menu']['index'] - $this->_sections['menu']['step'];
$this->_sections['menu']['index_next'] = $this->_sections['menu']['index'] + $this->_sections['menu']['step'];
$this->_sections['menu']['first']      = ($this->_sections['menu']['iteration'] == 1);
$this->_sections['menu']['last']       = ($this->_sections['menu']['iteration'] == $this->_sections['menu']['total']);
?>
<li style="margin-left: 20px; margin-top: 0px">
<a href="<?php echo $this->_tpl_vars['MAIN_MENU_URL']; ?>
&project=<?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['project']; ?>
"><?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['title']; ?>
</a>
<ul style="padding: 0px; margin: 0px">
<?php unset($this->_sections['menuitem']);
$this->_sections['menuitem']['name'] = 'menuitem';
$this->_sections['menuitem']['loop'] = is_array($_loop=$this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['menuitem']['show'] = true;
$this->_sections['menuitem']['max'] = $this->_sections['menuitem']['loop'];
$this->_sections['menuitem']['step'] = 1;
$this->_sections['menuitem']['start'] = $this->_sections['menuitem']['step'] > 0 ? 0 : $this->_sections['menuitem']['loop']-1;
if ($this->_sections['menuitem']['show']) {
    $this->_sections['menuitem']['total'] = $this->_sections['menuitem']['loop'];
    if ($this->_sections['menuitem']['total'] == 0)
        $this->_sections['menuitem']['show'] = false;
} else
    $this->_sections['menuitem']['total'] = 0;
if ($this->_sections['menuitem']['show']):

            for ($this->_sections['menuitem']['index'] = $this->_sections['menuitem']['start'], $this->_sections['menuitem']['iteration'] = 1;
                 $this->_sections['menuitem']['iteration'] <= $this->_sections['menuitem']['total'];
                 $this->_sections['menuitem']['index'] += $this->_sections['menuitem']['step'], $this->_sections['menuitem']['iteration']++):
$this->_sections['menuitem']['rownum'] = $this->_sections['menuitem']['iteration'];
$this->_sections['menuitem']['index_prev'] = $this->_sections['menuitem']['index'] - $this->_sections['menuitem']['step'];
$this->_sections['menuitem']['index_next'] = $this->_sections['menuitem']['index'] + $this->_sections['menuitem']['step'];
$this->_sections['menuitem']['first']      = ($this->_sections['menuitem']['iteration'] == 1);
$this->_sections['menuitem']['last']       = ($this->_sections['menuitem']['iteration'] == $this->_sections['menuitem']['total']);
?>
<?php if (isset ( $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items'][$this->_sections['menuitem']['index']]['reportname'] )): ?>
<li ><a href="<?php echo $this->_tpl_vars['RUN_REPORT_URL']; ?>
&project=<?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['project']; ?>
&xmlin=<?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items'][$this->_sections['menuitem']['index']]['reportfile']; ?>
"><?php echo $this->_tpl_vars['DROPDOWN_MENU_ITEMS'][$this->_sections['menu']['index']]['items'][$this->_sections['menuitem']['index']]['reportname']; ?>
</a></li>
<?php endif; ?>
<?php endfor; endif; ?>
</ul>
</li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<?php endif; ?>

<?php if (! $this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<?php if ($this->_tpl_vars['SHOW_TOPMENU']): ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_NAVIGATION_MENU'] == 'show'): ?>
	<TABLE class="swPrpTopMenu">
<?php else: ?>
	<TABLE style="display:none" class="swPrpTopMenu">
<?php endif; ?>
		<TR>
			<TD style="width: 50%; text-align:left">
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_GO_BUTTONS'] == 'show'): ?>
    				<input type="submit" style="width: 0px; color: transparent; background-color: transparent; border-color: transparent; cursor: default;" class="prepareAjaxExecute swHTMLGoBox" id="prepareAjaxExecute" name="submitPrepare" value="<?php echo $this->_tpl_vars['T_GO']; ?>
">
<?php endif; ?>
<?php if (( $this->_tpl_vars['SHOW_ADMIN_BUTTON'] )): ?>
<?php if (strlen ( $this->_tpl_vars['ADMIN_MENU_URL'] ) > 0): ?> 
                <a class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_ADMIN_BUTTON']; ?>
swLinkMenu" href="<?php echo $this->_tpl_vars['ADMIN_MENU_URL']; ?>
"><?php echo $this->_tpl_vars['T_ADMIN_MENU']; ?>
</a>
<?php endif; ?>
<?php endif; ?>
<?php if (strlen ( $this->_tpl_vars['MAIN_MENU_URL'] ) > 0): ?> 
<?php if ($this->_tpl_vars['SHOW_PROJECT_MENU_BUTTON']): ?>
				<a class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_ADMIN_BUTTON']; ?>
swLinkMenu" href="<?php echo $this->_tpl_vars['MAIN_MENU_URL']; ?>
"><?php echo $this->_tpl_vars['T_PROJECT_MENU']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_DESIGN_BUTTON']): ?>
                                &nbsp;<input class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_ADMIN_BUTTON']; ?>
swLinkMenu" type="submit" name="submit_design_mode" value="<?php echo $this->_tpl_vars['T_DESIGN_REPORT']; ?>
">
<?php endif; ?>
<?php if ($this->_tpl_vars['OUTPUT_SHOW_DEBUG']): ?>
<?php if ($this->_tpl_vars['SHOW_DESIGN_BUTTON']): ?>
			<TD style="width:15%; text-align: right; padding-right: 10px;" class="swPrpTopMenuCell">
				<?php echo $this->_tpl_vars['T_DEBUG_LEVEL']; ?>

				<SELECT class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_DROPDOWN']; ?>
" style="display:inline; width: auto" name="debug_mode">';
					<OPTION <?php echo $this->_tpl_vars['DEBUG_NONE']; ?>
 label="None" value="0"><?php echo $this->_tpl_vars['T_DEBUG_NONE']; ?>
</OPTION>
					<OPTION <?php echo $this->_tpl_vars['DEBUG_LOW']; ?>
 label="Low" value="1"><?php echo $this->_tpl_vars['T_DEBUG_LOW']; ?>
</OPTION>
					<OPTION <?php echo $this->_tpl_vars['DEBUG_MEDIUM']; ?>
 label="Medium" value="2"><?php echo $this->_tpl_vars['T_DEBUG_MEDIUM']; ?>
</OPTION>
					<OPTION <?php echo $this->_tpl_vars['DEBUG_HIGH']; ?>
 label="High" value="3"><?php echo $this->_tpl_vars['T_DEBUG_HIGH']; ?>
</OPTION>
				</SELECT>
			</TD>
<?php endif; ?>
<?php endif; ?>

<?php endif; ?>
			</TD>
<?php if ($this->_tpl_vars['SHOW_LOGOUT']): ?>
			<TD style="width:15%; text-align: right; padding-right: 10px;" class="swPrpTopMenuCell">
				<input class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_ADMIN_BUTTON']; ?>
swLinkMenu" type="submit" name="logout" value="<?php echo $this->_tpl_vars['T_LOGOFF']; ?>
">
			</TD>
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_LOGIN']): ?>
			<TD width="10%"></TD>
			<TD width="55%" align="left" class="swPrpTopMenuCell">
<?php if (strlen ( $this->_tpl_vars['PROJ_PASSWORD_ERROR'] ) > 0): ?>
                                <div style="color: #ff0000;"><?php echo $this->_tpl_vars['T_PASSWORD_ERROR']; ?>
</div>
<?php endif; ?>
				<?php echo $this->_tpl_vars['T_ENTER_PROJECT_PASSWORD']; ?>
<br><input type="password" name="project_password" value=""></div>
				<input class="swLinkMenu" type="submit" name="login" value="<?php echo $this->_tpl_vars['T_LOGIN']; ?>
">
			</TD>
<?php endif; ?>
		</TR>
	</TABLE>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_MINIMAINTAIN']): ?> 
<?php if (! $this->_tpl_vars['REPORTICO_BOOTSTRAP_MODAL']): ?>
<div style="width: 100%; padding-top: 3px; text-align: right">
    				<input type="submit" class="prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITSQL']; ?>
" id="submit_mainquerqury_SHOW" value="<?php echo $this->_tpl_vars['T_EDITSQL']; ?>
" name="mainquerqurysqlt_QuerySql">
    				<input type="submit" class="prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITCOLUMNS']; ?>
" id="submit_mainquerquryqcol_SHOW" value="<?php echo $this->_tpl_vars['T_EDITCOLUMNS']; ?>
" name="mainquerquryqcol_ANY">
    				<input type="submit" class="prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITASSIGNMENT']; ?>
" id="submit_mainquerassg" value="<?php echo $this->_tpl_vars['T_EDITASSIGNMENT']; ?>
" name="mainquerassg_ANY">
    				<input type="submit" class="prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITGROUPS']; ?>
" id="submit_mainqueroutpgrps" value="<?php echo $this->_tpl_vars['T_EDITGROUPS']; ?>
" name="mainqueroutpgrps_ANY">
    				<input type="submit" class="prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITGRAPHS']; ?>
" id="submit_mainqueroutpgrph" value="<?php echo $this->_tpl_vars['T_EDITGRAPHS']; ?>
" name="mainqueroutpgrph_ANY">
</div>
<?php else: ?>


<div class="navbar navbar-default reportico-navbar" role="navigation">
    <!--div class="navbar navbar-default navbar-static-top" role="navigation"-->
        <div class="container" style="width: 100%">
            <div class="nav-collapse collapse in" id="reportico-bootstrap-collapse">
                <ul class="nav navbar-nav pull-right navbar-right">
    				    <li style="display: inline-block; margin-right: 40px">
<?php echo $this->_tpl_vars['T_REPORT_FILE']; ?>
 <input type="text" name="xmlout" id="swPrpSaveFile" value="<?php echo $this->_tpl_vars['XMLFILE']; ?>
"> <input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_PRIMARY_BUTTON']; ?>
 swPrpSaveButton" type="submit" name="submit_xxx_SAVE" value="<?php echo $this->_tpl_vars['T_SAVE']; ?>
">
                        </li>
    				    <li  style="display: inline-block"><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-top: 10px; margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITSQL']; ?>
" id="submit_mainquerqury_SHOW" value="<?php echo $this->_tpl_vars['T_EDITSQL']; ?>
" name="mainquerqurysqlt_QuerySql"></li>
    				    <li style="display: inline-block"><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-top: 10px; margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITCOLUMNS']; ?>
" id="submit_mainquerquryqcol_SHOW" value="<?php echo $this->_tpl_vars['T_EDITCOLUMNS']; ?>
" name="mainquerquryqcol_ANY"></li>
    				    <li style="display: inline-block"><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-top: 10px; margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITASSIGNMENT']; ?>
" id="submit_mainquerassg" value="<?php echo $this->_tpl_vars['T_EDITASSIGNMENT']; ?>
" name="mainquerassg_ANY"></li>
    				    <li style="display: inline-block"><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-top: 10px; margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITGROUPS']; ?>
" id="submit_mainqueroutpgrps" value="<?php echo $this->_tpl_vars['T_EDITGROUPS']; ?>
" name="mainqueroutpgrps_ANY"></li>
    				    <li style="display: inline-block"><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-top: 10px; margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITGRAPHS']; ?>
" id="submit_mainqueroutpgrph" value="<?php echo $this->_tpl_vars['T_EDITGRAPHS']; ?>
" name="mainqueroutpgrph_ANY"></li>
                        <li style="display: inline-block" class="dropdown"><a class="dropdown-toggle reportico-dropdown-link" data-toggle="dropdown" href="#">More Shortcuts<span class="caret"></span></a>
                            <ul class="dropdown-menu reportico-dropdown">
    				            <li><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITPAGEHEADERS']; ?>
" id="submit_mainqueroutppghd0000form" value="<?php echo $this->_tpl_vars['T_EDITPAGEHEADERS']; ?>
" name="mainqueroutppghd0000form_ANY"></li>
    				            <li><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITPAGEFOOTERS']; ?>
" id="submit_mainqueroutppgft0000form" value="<?php echo $this->_tpl_vars['T_EDITPAGEFOOTERS']; ?>
" name="mainqueroutppgft0000form_ANY"></li>
    				            <li><input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-top: 10px; margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITPRESQLS']; ?>
" id="submit_mainquerqurypsql_SHOW" value="<?php echo $this->_tpl_vars['T_EDITPRESQLS']; ?>
" name="mainquerqurypsql_ANY"></li>
                            </ul>
                        </li>
                </ul>
            </div>
        </div>
</div>

<?php endif; ?>
<?php endif; ?>



<h1 class="swTitle" ><?php echo $this->_tpl_vars['TITLE']; ?>

<?php if ($this->_tpl_vars['SHOW_MINIMAINTAIN']): ?> 
<?php if (! $this->_tpl_vars['REPORTICO_BOOTSTRAP_MODAL']): ?>
    				<input type="submit" class="prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITTITLE']; ?>
" id="submit_mainquerform_SHOW" value="" name="mainquerform_ReportTitle">
<?php else: ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITTITLE']; ?>
" id="submit_mainquerform_SHOW" value="" name="mainquerform_ReportTitle">
<?php endif; ?>
<?php endif; ?>
</h1>
<?php if ($this->_tpl_vars['SHOW_CRITERIA']): ?>
    <div style="display: none">
										&nbsp;
										<?php echo $this->_tpl_vars['T_OUTPUT']; ?>

											<INPUT type="radio" id="rpt_format_html" name="target_format" value="HTML" <?php echo $this->_tpl_vars['OUTPUT_TYPES'][0]; ?>
>HTML
											<INPUT type="radio" id="rpt_format_pdf" name="target_format" value="PDF" <?php echo $this->_tpl_vars['OUTPUT_TYPES'][1]; ?>
>PDF
											<INPUT type="radio" id="rpt_format_csv" name="target_format" value="CSV" <?php echo $this->_tpl_vars['OUTPUT_TYPES'][2]; ?>
>CSV
<?php if ($this->_tpl_vars['SHOW_DESIGN_BUTTON']): ?>
											<!--INPUT type="radio" id="rpt_format_xml" name="target_format" value="XML" <?php echo $this->_tpl_vars['OUTPUT_TYPES'][3]; ?>
>XML-->
											<!--INPUT type="radio" id="rpt_format_json" name="target_format" value="JSON" <?php echo $this->_tpl_vars['OUTPUT_TYPES'][4]; ?>
>JSON-->
<?php endif; ?>
   
    </div>
	<TABLE class="swPrpCritBox" id="critbody">
<?php if ($this->_tpl_vars['SHOW_OUTPUT'] && ! $this->_tpl_vars['IS_ADMIN_SCREEN']): ?>
        <TR>
            <td>  
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_PAGE_STYLE'] == 'show'): ?>
			<div style="padding: 10px 15px; float: left;vertical-align: bottom;text-align: center; border-right: solid 1px #bbb">
<?php else: ?>
			<div style="display:none; width: 20%; padding-top: 15px;float: left;vertical-align: bottom;text-align: center">
<?php endif; ?>
                <b><?php echo $this->_tpl_vars['T_REPORT_STYLE']; ?>
</b>

<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active" style="padding: 2px 4px">
    <input type="radio" name="target_style" id="rpt_style_detail" autocomplete="off" value="TABLE" <?php echo $this->_tpl_vars['OUTPUT_STYLES'][0]; ?>
><?php echo $this->_tpl_vars['T_TABLE']; ?>

  </label>
  <label class="btn btn-primary" style="padding: 2px 4px">
    <input type="radio" name="target_style" id="rpt_style_form" autocomplete="off" value="FORM" <?php echo $this->_tpl_vars['OUTPUT_STYLES'][1]; ?>
><?php echo $this->_tpl_vars['T_FORM']; ?>

  </label>
</div>
<?php else: ?>
<INPUT type="radio" id="rpt_style_detail" name="target_style" value="TABLE" <?php echo $this->_tpl_vars['OUTPUT_STYLES'][0]; ?>
><?php echo $this->_tpl_vars['T_TABLE']; ?>

<INPUT type="radio" id="rpt_style_form" name="target_style" value="FORM" <?php echo $this->_tpl_vars['OUTPUT_STYLES'][1]; ?>
><?php echo $this->_tpl_vars['T_FORM']; ?>

<?php endif; ?>
			</div>
			<div class="swPrpToolbarPane" style="padding: 0px 5px; float: left;vertical-align: bottom;text-align: center; border-right: solid 1px #bbb">
<?php if ($this->_tpl_vars['SHOW_DESIGN_BUTTON']): ?>
    				<!--input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swJSONBox" title="<?php echo $this->_tpl_vars['T_PRINT_JSON']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value=""-->
    				<!--input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swXMLBox" style="margin-left: 20px" title="<?php echo $this->_tpl_vars['T_PRINT_XML']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value=""-->
<?php endif; ?>

<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_CSV_BUTTON'] == 'show'): ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swCSVBox" title="<?php echo $this->_tpl_vars['T_PRINT_CSV']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php else: ?>
    				<input style="display:none" type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swCSVBox" title="<?php echo $this->_tpl_vars['T_PRINT_CSV']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_PDF_BUTTON'] == 'show'): ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swPDFBox" title="<?php echo $this->_tpl_vars['T_PRINT_PDF']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php else: ?>
    				<input style="display:none" type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swPDFBox" title="<?php echo $this->_tpl_vars['T_PRINT_PDF']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_HTML_BUTTON'] == 'show'): ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swHTMLBox" title="<?php echo $this->_tpl_vars['T_PRINT_HTML']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php else: ?>
    				<input style="display:none" type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swHTMLBox" title="<?php echo $this->_tpl_vars['T_PRINT_HTML']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_PRINT_HTML_BUTTON'] == 'show'): ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swPrintBox" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_PRINTABLE']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php else: ?>
    				<input style="display:none" type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareAjaxExecute swPrintBox" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_PRINTABLE']; ?>
" id="prepareAjaxExecute" name="submitPrepare" value="">
<?php endif; ?>
			</div>

<?php if (! $this->_tpl_vars['OUTPUT_SHOW_SHOWGRAPH']): ?>
                                        <input style="display:none" type="checkbox" name="target_show_graph" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGRAPH']; ?>
>
<?php endif; ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
				<INPUT type="checkbox" style="display:none" name="user_criteria_entered" value="1" checked="1">
            <div class="container" style="width: 100%">
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
                <div class= "nav-collapse collapse" id="reportico-bootstrap-collapse">
<?php else: ?>
                <div class="nav-collapse collapse in" id="reportico-bootstrap-collapse">
<?php endif; ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
                    <ul style="margin: 10px 0px 0px 20px" class="nav navbar-nav pull-left navbar-right">
<?php else: ?>
                    <ul class="nav navbar-nav pull-right navbar-right">
<?php endif; ?>
                            <li class="dropdown"><a class="dropdown-toggle reportico-dropdown-link" data-toggle="dropdown" href="#"><?php echo $this->_tpl_vars['T_SHOW']; ?>
<span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right reportico-dropdown" style="padding-top:0px; padding-bottom:0px">
    				                <li>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
                                        <input class="reportico_bootstrap2_checkbox" type="checkbox" name="target_show_criteria" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWCRITERIA']; ?>
>
                                        <label style="display:inline"><?php echo $this->_tpl_vars['T_SHOW_CRITERIA']; ?>
</label>
<?php else: ?>
                                        <div class="input-group" style="margin-bottom: 0px; ; float: right">
                                            <label style="width:200px" class="form-control" aria-label="Text input with checkbox"><?php echo $this->_tpl_vars['T_SHOW_CRITERIA']; ?>
</label>
                                            <span class="input-group-addon">
                                                <input type="checkbox" name="target_show_criteria" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWCRITERIA']; ?>
>
                                            </span>
                                        </div>
<?php endif; ?>
                                    </li>
                                    <li>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
                                        <input class="reportico_bootstrap2_checkbox" type="checkbox" name="target_show_detail" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWDETAIL']; ?>
>
                                        <label style="display:inline"><?php echo $this->_tpl_vars['T_SHOW_DETAIL']; ?>
</label>
<?php else: ?>
                                        <div class="input-group" style="margin-bottom: 0px; ; float: right">
                                            <label class="form-control" aria-label="Text input with checkbox"><?php echo $this->_tpl_vars['T_SHOW_DETAIL']; ?>
</label>
                                            <span class="input-group-addon">
                                                <input type="checkbox" name="target_show_detail" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWDETAIL']; ?>
>
                                            </span>
                                        </div>
<?php endif; ?>
                                    </li>
<?php if ($this->_tpl_vars['OUTPUT_SHOW_SHOWGRAPH']): ?>
    				                <li>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
                                        <input class="reportico_bootstrap2_checkbox" type="checkbox" name="target_show_graph" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGRAPH']; ?>
>
                                        <label style="display:inline"><?php echo $this->_tpl_vars['T_SHOW_GRAPH']; ?>
</label>
<?php else: ?>
                                        <div class="input-group" style="margin-bottom: 0px; ; float: right">
                                            <label class="form-control" aria-label="Text input with checkbox"><?php echo $this->_tpl_vars['T_SHOW_GRAPH']; ?>
</label>
                                            <span class="input-group-addon">
                                                <input type="checkbox" name="target_show_graph" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGRAPH']; ?>
>
                                            </span>
                                        </div>
<?php endif; ?>
                                    </li>
<?php endif; ?>
    				                <li>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
                                        <input class="reportico_bootstrap2_checkbox" type="checkbox" name="target_show_group_headers" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGROUPHEADERS']; ?>
>
                                        <label style="display:inline"><?php echo $this->_tpl_vars['T_SHOW_GRPHEADERS']; ?>
</label>
<?php else: ?>
                                        <div class="input-group" style="margin-bottom: 0px; ; float: right">
                                            <label class="form-control" aria-label="Text input with checkbox"><?php echo $this->_tpl_vars['T_SHOW_GRPHEADERS']; ?>
</label>
                                            <span class="input-group-addon">
                                                <input type="checkbox" name="target_show_group_headers" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGROUPHEADERS']; ?>
>
                                            </span>
                                        </div>
<?php endif; ?>
                                    </li>
    				                <li>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '2'): ?>
                                        <input class="reportico_bootstrap2_checkbox" type="checkbox" name="target_show_group_trailers" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGROUPTRAILERS']; ?>
>
                                        <label style="display:inline"><?php echo $this->_tpl_vars['T_SHOW_GRPTRAILERS']; ?>
</label>
<?php else: ?>
                                        <div class="input-group" style="margin-bottom: 0px; ; float: right">
                                            <label class="form-control" aria-label="Text input with checkbox"><?php echo $this->_tpl_vars['T_SHOW_GRPTRAILERS']; ?>
</label>
                                            <span class="input-group-addon">
                                                <input type="checkbox" name="target_show_group_trailers" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGROUPTRAILERS']; ?>
>
                                            </span>
                                        </div>
<?php endif; ?>
                                    </li>
                                </ul>
                            </li>
                    </ul>
                </div>
            </div>
<?php else: ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_SECTION_BOXES'] == 'show'): ?>
			<div style="width: 50%; padding-top: 15px;float: left;vertical-align: bottom;text-align: center"> <b><?php echo $this->_tpl_vars['T_SHOW']; ?>
</b>
				<INPUT type="checkbox" style="display:none" name="user_criteria_entered" value="1" checked="1">
				<INPUT type="checkbox" name="target_show_criteria" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWCRITERIA']; ?>
><?php echo $this->_tpl_vars['T_SHOW_CRITERIA']; ?>

				<INPUT type="checkbox" name="target_show_detail" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWDETAIL']; ?>
><?php echo $this->_tpl_vars['T_SHOW_DETAIL']; ?>

				<INPUT type="checkbox" name="target_show_group_headers" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGROUPHEADERS']; ?>
><?php echo $this->_tpl_vars['T_SHOW_GRPHEADERS']; ?>

				<INPUT type="checkbox" name="target_show_group_trailers" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGROUPTRAILERS']; ?>
><?php echo $this->_tpl_vars['T_SHOW_GRPTRAILERS']; ?>

<?php if ($this->_tpl_vars['OUTPUT_SHOW_SHOWGRAPH'] && false): ?>
				<INPUT type="checkbox" name="target_show_graph" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWGRAPH']; ?>
><?php echo $this->_tpl_vars['T_SHOW_GRAPH']; ?>
<BR>
<?php endif; ?>
			</div>
<?php else: ?>
			<div style="width: 50%; padding-top: 15px;float: left;vertical-align: bottom;text-align: center"> <b><?php echo $this->_tpl_vars['T_SHOW']; ?>
</b>
				<INPUT type="checkbox" name="target_show_criteria" value="1" <?php echo $this->_tpl_vars['OUTPUT_SHOWCRITERIA']; ?>
><?php echo $this->_tpl_vars['T_SHOW_CRITERIA']; ?>

			</div>
<?php endif; ?>
<?php endif; ?>
            </td>
		</TR>
<?php endif; ?>
	</TABLE>
<div id="criteriabody">
	<TABLE class="swPrpCritBox" cellpadding="0">
<!---->
		<TR id="swPrpCriteriaBody">
			<TD class="swPrpCritEntry">
			<div id="swPrpSubmitPane">
<?php if (! $this->_tpl_vars['IS_ADMIN_SCREEN']): ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_GO_BUTTONS'] == 'show'): ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_GO_BUTTON']; ?>
prepareAjaxExecute swHTMLGoBox" id="prepareAjaxExecute" name="submitPrepare" value="<?php echo $this->_tpl_vars['T_GO']; ?>
">
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_HIDE_PREPARE_RESET_BUTTONS'] == 'show'): ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_RESET_BUTTON']; ?>
reporticoSubmit" name="clearform" value="<?php echo $this->_tpl_vars['T_RESET']; ?>
">
<?php endif; ?>
<?php else: ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_GO_BUTTON']; ?>
prepareAjaxExecute swHTMLGoBox" id="prepareAjaxExecute" name="submitPrepare" value="<?php echo $this->_tpl_vars['T_GO']; ?>
">
<?php endif; ?>
<?php if ($this->_tpl_vars['SHOW_MINIMAINTAIN']): ?> 
<div style="float: left">
<?php if (! $this->_tpl_vars['REPORTICO_BOOTSTRAP_MODAL']): ?>
    				<input type="submit" class="prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITCRITERIA']; ?>
" id="submit_mainquercrit" value="<?php echo $this->_tpl_vars['T_EDITCRITERIA']; ?>
" name="mainquercrit_ANY">
<?php else: ?>
    				<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TOOLBAR_BUTTON']; ?>
prepareMiniMaintain swMiniMaintain" style="margin-right: 30px" title="<?php echo $this->_tpl_vars['T_EDIT']; ?>
 <?php echo $this->_tpl_vars['T_EDITCRITERIA']; ?>
" id="submit_mainquercrit" value="<?php echo $this->_tpl_vars['T_EDITCRITERIA']; ?>
" name="mainquercrit_ANY">
<?php endif; ?>
</div>
<?php endif; ?>
                    &nbsp;
			</div>

                <TABLE class="swPrpCritEntryBox">
<?php 
$loopct = 0;
 ?>
<?php if (isset ( $this->_tpl_vars['CRITERIA_ITEMS'] )): ?>
<?php unset($this->_sections['critno']);
$this->_sections['critno']['name'] = 'critno';
$this->_sections['critno']['loop'] = is_array($_loop=$this->_tpl_vars['CRITERIA_ITEMS']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['critno']['show'] = true;
$this->_sections['critno']['max'] = $this->_sections['critno']['loop'];
$this->_sections['critno']['step'] = 1;
$this->_sections['critno']['start'] = $this->_sections['critno']['step'] > 0 ? 0 : $this->_sections['critno']['loop']-1;
if ($this->_sections['critno']['show']) {
    $this->_sections['critno']['total'] = $this->_sections['critno']['loop'];
    if ($this->_sections['critno']['total'] == 0)
        $this->_sections['critno']['show'] = false;
} else
    $this->_sections['critno']['total'] = 0;
if ($this->_sections['critno']['show']):

            for ($this->_sections['critno']['index'] = $this->_sections['critno']['start'], $this->_sections['critno']['iteration'] = 1;
                 $this->_sections['critno']['iteration'] <= $this->_sections['critno']['total'];
                 $this->_sections['critno']['index'] += $this->_sections['critno']['step'], $this->_sections['critno']['iteration']++):
$this->_sections['critno']['rownum'] = $this->_sections['critno']['iteration'];
$this->_sections['critno']['index_prev'] = $this->_sections['critno']['index'] - $this->_sections['critno']['step'];
$this->_sections['critno']['index_next'] = $this->_sections['critno']['index'] + $this->_sections['critno']['step'];
$this->_sections['critno']['first']      = ($this->_sections['critno']['iteration'] == 1);
$this->_sections['critno']['last']       = ($this->_sections['critno']['iteration'] == $this->_sections['critno']['total']);
?>
<?php if ($this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group'] && ( $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group'] != $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['last_display_group'] )): ?>
<tr id="swToggleCriteriaDiv<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group_class']; ?>
">
<td colspan="3">
<a class="swToggleCriteria" id="swToggleCriteria<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group_class']; ?>
" href="javascript:toggleCriteria('<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group_class']; ?>
')">+</a>
<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group']; ?>

</td>
</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['hidden'] || $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group']): ?>
<?php if ($this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group']): ?>
                    <tr class="swPrpCritLine  swDisplayGroupLine displayGroup<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['display_group_class']; ?>
" id="criteria_<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['name']; ?>
" style="display:none">
<?php else: ?>
                    <tr class="swPrpCritLine" id="criteria_<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['name']; ?>
" style="display:none">
<?php endif; ?>
<?php else: ?>
                    <tr class="swPrpCritLine" id="criteria_<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['name']; ?>
">
<?php endif; ?>
                        <td class='swPrpCritTitle'>
<?php if ($this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['tooltip']): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES']): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '3' || $this->_tpl_vars['BOOTSTRAP_STYLES'] == 'joomla3'): ?>
                            <a class='reportico_tooltip' data-toggle="tooltip" data-placement="right" title="<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['tooltip']; ?>
">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                            </a>
<?php else: ?>
                            <a class='reportico_tooltip' data-toggle="tooltip" data-placement="right" title="<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['tooltip']; ?>
">
                                    <span class="icon-question-sign"></span>
                            </a>
<?php endif; ?>
<?php else: ?>
                            <div class="swHelpIcon" alt="tab" title = "<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['tooltip']; ?>
"><img class="swHelpIcon"></img></div>
<?php endif; ?>
<?php endif; ?>
<?php 
$itemval = str_pad($loopct, 4, '0', STR_PAD_LEFT);
$this->assign('criterianumber', $itemval);
$loopct++;
 ?>
                            <?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['title']; ?>

                        </td>
                        <td class="swPrpCritSel">
                            <?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['entry']; ?>

                        </td>
                        <td class="swPrpCritExpandSel">
<?php if ($this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['expand']): ?>
<?php if ($this->_tpl_vars['AJAX_ENABLED']): ?> 
                            <input class="swPrpCritExpandButton" id="reporticoPerformExpand" type="button" name="EXPAND_<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['name']; ?>
" value="<?php echo $this->_tpl_vars['T_EXPAND']; ?>
">
<?php else: ?>
                            <input class="swPrpCritExpandButton" type="submit" name="EXPAND_<?php echo $this->_tpl_vars['CRITERIA_ITEMS'][$this->_sections['critno']['index']]['name']; ?>
" value="<?php echo $this->_tpl_vars['T_EXPAND']; ?>
">
<?php endif; ?>
<?php endif; ?>
                        </td>
                    </TR>
<?php endfor; endif; ?>
<?php endif; ?>
                </TABLE>
<?php if (isset ( $this->_tpl_vars['CRITERIA_ITEMS'] )): ?>
<?php if (count ( $this->_tpl_vars['CRITERIA_ITEMS'] ) > 1): ?>
<div id="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_SMALL_BUTTON']; ?>
swPrpSubmitPane">
<?php if (! $this->_tpl_vars['IS_ADMIN_SCREEN']): ?>
	<input type="submit" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_GO_BUTTON']; ?>
prepareAjaxExecute swHTMLGoBox" id="prepareAjaxExecute" name="submitPrepare" value="<?php echo $this->_tpl_vars['T_GO']; ?>
">
<?php endif; ?>
    <!--input type="submit" class="reporticoSubmit" name="clearform" value="<?php echo $this->_tpl_vars['T_RESET']; ?>
"-->
</div>
<?php endif; ?>
<?php endif; ?>
			</td>
			<TD class="swPrpExpand">
				<TABLE class="swPrpExpandBox">
					<TR class="swPrpExpandRow">
						<TD id="swPrpExpandCell" rowspan="0" valign="top">
<?php if (strlen ( $this->_tpl_vars['ERRORMSG'] ) > 0): ?>
            <TABLE class="swError">
                <TR>
                    <TD><?php echo $this->_tpl_vars['ERRORMSG']; ?>
</TD>
                </TR>
            </TABLE>
<?php endif; ?>
<?php if (strlen ( $this->_tpl_vars['STATUSMSG'] ) > 0): ?> 
			<TABLE class="swStatus">
				<TR>
					<TD><?php echo $this->_tpl_vars['STATUSMSG']; ?>
</TD>
				</TR>
			</TABLE>
<?php endif; ?>
<?php if (strlen ( $this->_tpl_vars['STATUSMSG'] ) == 0 && strlen ( $this->_tpl_vars['ERRORMSG'] ) == 0): ?>
<div style="float:right; ">
<?php if (strlen ( $this->_tpl_vars['MAIN_MENU_URL'] ) > 0): ?>
<!--a class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_ADMIN_BUTTON']; ?>
swLinkMenu" style="float:left;" href="<?php echo $this->_tpl_vars['MAIN_MENU_URL']; ?>
">&lt;&lt; Menu</a-->
<?php endif; ?>
</div>
<p>
<?php if ($this->_tpl_vars['SHOW_EXPANDED']): ?>
							<?php echo $this->_tpl_vars['T_SEARCH']; ?>
 <?php echo $this->_tpl_vars['EXPANDED_TITLE']; ?>
 :<br><input  id="expandsearch" type="text" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_TEXTFIELD']; ?>
" name="expand_value" style="width: 50%;display: inline" size="30" value="<?php echo $this->_tpl_vars['EXPANDED_SEARCH_VALUE']; ?>
"</input>
									<input id="reporticoSearchExpand" class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_SMALL_BUTTON']; ?>
swPrpSubmit" style="margin-bottom: 2px" type="submit" name="EXPANDSEARCH_<?php echo $this->_tpl_vars['EXPANDED_ITEM']; ?>
" value="Search"><br>

<?php echo $this->_tpl_vars['CONTENT']; ?>

							<br>
							<input class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_SMALL_BUTTON']; ?>
swPrpSubmit" type="submit" name="EXPANDCLEAR_<?php echo $this->_tpl_vars['EXPANDED_ITEM']; ?>
" value="Clear">
							<input class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_SMALL_BUTTON']; ?>
swPrpSubmit" type="submit" name="EXPANDSELECTALL_<?php echo $this->_tpl_vars['EXPANDED_ITEM']; ?>
" value="Select All">
							<input class="<?php echo $this->_tpl_vars['BOOTSTRAP_STYLE_SMALL_BUTTON']; ?>
swPrpSubmit" type="submit" name="EXPANDOK_<?php echo $this->_tpl_vars['EXPANDED_ITEM']; ?>
" value="OK">
<?php endif; ?>
<?php if (! $this->_tpl_vars['SHOW_EXPANDED']): ?>
<?php if (! $this->_tpl_vars['REPORT_DESCRIPTION']): ?>
<?php echo $this->_tpl_vars['T_DEFAULT_REPORT_DESCRIPTION']; ?>

<?php else: ?>
						&nbsp;<br>
						<?php echo $this->_tpl_vars['REPORT_DESCRIPTION']; ?>

<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
						</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
			</TABLE>

<?php endif; ?>
</div>
			<!---->

</FORM>
<?php if ($this->_tpl_vars['REPORTICO_BOOTSTRAP_MODAL']): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '3' || $this->_tpl_vars['BOOTSTRAP_STYLES'] == 'joomla3'): ?>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == 'joomla3'): ?>
<?php echo '
<style type="text/css">
    #reporticoModal .modal-dialog .modal-content
    {
        width:900px; margin-left:-150px;
    }
</style>
'; ?>

<?php endif; ?>
<a id="a_reporticoModal" href="#reporticoModal" role="button" class="btn" data-target="#reporticoModal" data-toggle="modal" style="display:none">BB2</a>
<div class="modal fade" id="reporticoModal" tabindex="-1" role="dialog" aria-labelledby="reporticoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
<?php else: ?>
<a id="a_reporticoModal" href="#reporticoModal" role="button" class="btn" data-target="#reporticoModal" data-toggle="modal" style="display:none">BB2</a>
<div class="modal fade" style="width: 900px; margin-left: -450px" id="reporticoModal" tabindex="-1" role="dialog" aria-labelledby="reporticoModal" aria-hidden="true">
    <div class="modal-dialog">
<?php endif; ?>
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close reportico-bootstrap-modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title reportico-modal-title" id="reporticoModalLabel">Set Parameter</h4>
            </div>
            <div class="modal-body" style="padding: 0px; overflow-y: auto" id="swMiniMaintain">
                <h3>Modal Body</h3>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary swMiniMaintainSubmit" >Close</button>
        </div>
    </div>
  </div>
</div>
<?php if ($this->_tpl_vars['BOOTSTRAP_STYLES'] == '3' || $this->_tpl_vars['BOOTSTRAP_STYLES'] == 'joomla3'): ?>
<a id="a_reporticoNoticeModal" href="#reporticoNoticeModal" role="button" class="btn" data-target="#reporticoNoticeModal" data-toggle="modal" style="display:none">B2</a>
<div class="modal fade" id="reporticoNoticeModal" tabindex="-1" role="dialog" aria-labelledby="reporticoNoticeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
<?php else: ?>
<a id="a_reporticoNoticeModal" href="#reporticoNoticeModal" role="button" class="btn" data-target="#reporticoNoticeModal" data-toggle="modal" style="display:none">B2</a>
<div class="modal hide fade" id="reporticoNoticeModal" tabindex="-1" role="dialog" aria-labelledby="reporticoNoticeModal" aria-hidden="true">
    <div class="modal-dialog">
<?php endif; ?>
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" data-dismiss="modal" class="close" aria-hidden="true">&times;</button>
            <h4 class="modal-title reportico-notice-modal-title" id="reporticoNoticeModalLabel"><?php echo $this->_tpl_vars['T_NOTICE']; ?>
</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; padding: 0px" id="reporticoNoticeModalBody">
                <h3>Modal Body</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<?php else: ?>
<div id="reporticoModal" tabindex="-1" class="reportico-modal">
    <div class="reportico-modal-dialog">
        <div class="reportico-modal-content">
            <div class="reportico-modal-header">
            <button type="button" class="reportico-modal-close">&times;</button>
            <h4 class="reportico-modal-title" id="reporticoModalLabel"><?php echo $this->_tpl_vars['T_NOTICE']; ?>
</h4>
            </div>
            <div class="reportico-modal-body" style="padding: 0px" id="swMiniMaintain">
                <h3>Modal Body</h3>
            </div>
            <div class="reportico-modal-footer">
                <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
                <button type="button" class="swMiniMaintainSubmit" >Close</button>
        </div>
    </div>
  </div>
</div>

<div id="reporticoNoticeModal" tabindex="-1" class="reportico-notice-modal">
    <div class="reportico-notice-modal-dialog">
        <div class="reportico-notice-modal-content">
            <div class="reportico-notice-modal-header">
            <button type="button" class="reportico-notice-modal-close">&times;</button>
            <h4 class="reportico-notice-modal-title" id="reporticoNoticeModalLabel">Set Parameter</h4>
            </div>
            <div class="reportico-notice-modal-body" id="reporticoNoticeModalBody">
                <h3>Modal Body</h3>
            </div>
            <div class="reportico-notice-modal-footer">
                <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
                <button type="button" class="reportico-notice-modal-button" >Close</button>
        </div>
    </div>
  </div>
</div>
<?php endif; ?>
<!--div class="smallbanner">Powered by <a href="http://www.reportico.org/" target="_blank">reportico <?php echo $this->_tpl_vars['REPORTICO_VERSION']; ?>
</a></div-->
</div>
<?php if (! $this->_tpl_vars['EMBEDDED_REPORT']): ?> 
</BODY>
</HTML>
<?php endif; ?>