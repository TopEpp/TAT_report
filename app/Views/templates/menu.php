<?php $session = session();
$request = \Config\Services::request();
$controller =  $request->uri->getSegment(1);
$method =  $request->uri->getSegment(2);
$user_menu = $session->get('user_menu');
?>
<style>
    .sidebar-dark .nav-item .nav-link {
        width: 100%;
    }

    #wrapper #content-wrapper {
        overflow-x: hidden;
    }

    @media (min-width: 768px) {
        .sidebar.toggled .nav-item .nav-link {
            padding: 0.75rem 0px !important;
        }
    }
    .sidebar .nav-item .collapse .collapse-inner, .sidebar .nav-item .collapsing .collapse-inner{
        min-width: 30rem;
    }
</style>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12" style="text-align:center; ">
            <div class="sidebar-brand-icon ">
                <a href="<?php echo base_url('main/daily'); ?>"><img src="<?php echo base_url('public/img/tat.png'); ?>" alt="" width="100px"></a>
            </div>
        </div>
    </div>



    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    <?php if($session->get('report_type') == 'daily'){ ?>
    
   <!--  <li class="nav-item <?php if ($controller == 'main') {
                            echo 'active';
                        } ?>">
        <a class="nav-link <?php if ($controller == 'main' && ($method == 'daily' || $method == '')) {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/daily') ?>">
            <i class="fas fa-fw fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
       
    </li> -->
     <li class="nav-item <?php if ($controller == 'main' && $method!='departure' ) {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDashboard" aria-expanded="true" aria-controls="collapseDashboard">
            <i class="fas fa-fw fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
        <div id="collapseDashboard" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded menusideNav">
                <a class="collapse-item <?php if ($method == 'daily') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/daily') ?>">สถิตินักท่องเที่ยวรายวัน</a>
                <a class="collapse-item <?php if ($method == 'country') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/country') ?>">สถิตินักท่องเที่ยวรายประเทศ</a>
               <!--  <a class="collapse-item <?php if ($method == 'departure') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/departure') ?>">สถิติคนไทยเดินทางออกนอกราชอาณาจักรในภาพรวม</a> -->
               
            </div>
        </div>
    </li>

    <?php if( !empty($user_menu['REPORT']) ){?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if ($controller == 'report' && $method!='departure') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseReport">
            <i class="fas fa-fw fa-table"></i>
            <span>Report</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded menusideNav">
                <a class="collapse-item <?php if ($method == 'nation') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/nation') ?>">รายงานจำนวนนักท่องเที่ยวรายสัญชาติ</a>
                <a class="collapse-item <?php if ($method == 'port') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/port') ?>">รายงานจำนวนนักท่องเที่ยวรายด่าน</a>
                <a class="collapse-item <?php if ($method == 'nation_compare') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/nation_compare') ?>">รายงานเปรียบเทียบจำนวนนักท่องเที่ยวรายสัญชาติ</a>
                <a class="collapse-item <?php if ($method == 'port_compare' || $method == 'port_compare_monthly') {
                                            echo 'active';
                                        } ?>" href="#">รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน (สะสม)</a>
                <a class="collapse-item <?php if ($method == 'port_compare') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/port_compare') ?>"><span style="padding-left: 15px;">- รายวัน</span></a>
                <a class="collapse-item <?php if ($method == 'port_compare_monthly') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/port_compare_monthly') ?>"><span style="padding-left: 15px;">- รายเดือน</span></a>
                <a class="collapse-item <?php if ($method == 'market') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/market') ?>">รายงานจำนวนนักท่องเที่ยวจำแนกรายรายตลาด</a>
                <a class="collapse-item <?php if ($method == 'nation_daily') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/nation_daily') ?>">รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายสัญชาติ</a>
                <a class="collapse-item <?php if ($method == 'port_daily') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/port_daily') ?>">รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายด่าน</a>
                <!-- <a class="collapse-item <?php if ($method == 'departure') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/departure') ?>">สถิติคนไทยเดินทางออกนอกประเทศ รายวัน</a> -->
               
            </div>
        </div>
    </li>
    <?php }?>
    <?php if( !empty($user_menu['DEPARTURE']) ){?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if ($method=='departure') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportDeparture" aria-expanded="true" aria-controls="collapseReportDeparture">
            <i class="fas fa-fw fa-table"></i>
            <span>Thai Outgoing Report </span>
        </a>
        <div id="collapseReportDeparture" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded menusideNav">

                <a class="collapse-item <?php if ($method == 'departure' && $controller == 'main') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/departure') ?>">สถิติคนไทยเดินทางออกนอกราชอาณาจักรในภาพรวม</a>
                <a class="collapse-item <?php if ($method == 'departure' && $controller == 'report') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/departure') ?>">สถิติคนไทยเดินทางออกนอกประเทศ รายวัน</a>
               
            </div>
        </div>
    </li>
    <?php }?>
    <li class="nav-item">
        <a class="nav-link" target="_blank" href="<?php echo base_url('public/uploads/definition.pdf') ?>">
            <i class="fas fa-fw fa-file"></i>
            <span>คำนิยาม</span>
        </a>
    </li>
    <?php if( !empty($user_menu['IMPORT']) ){?>
    <li class="nav-item <?php if ($controller == 'import') {
                            echo 'active';
                        } ?>">
        <a class="nav-link  <?php if ( $controller == 'import' && ($method == 'index' || $method == '')) {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('import') ?>"> 
                                        <i class="fas fa-fw fa-upload"></i>
            <span>Import</span></a>
    </li>
    <?php }?>

    <?php if( !empty($user_menu['SETTING']) ){?>
    <li class="nav-item <?php if ($controller == 'setting') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
        <div id="collapseSetting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded menusideNav">
                <!-- <h6 class="collapse-header">Report:</h6> -->
                <a class="collapse-item <?php if ($method == 'country') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('setting/country') ?>">Country</a>
                <a class="collapse-item <?php if ($method == 'port') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('setting/port') ?>">Port</a>
                <a class="collapse-item <?php if ($method == 'visa') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('setting/visa') ?>">Visa</a>
                <a class="collapse-item <?php if ($method == 'permission') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('setting/permission') ?>">Permission</a>
                <a class="collapse-item <?php if ($method == 'log_login') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('setting/log_login') ?>">Log Login</a>
                <a class="collapse-item <?php if ($method == 'log_info') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('setting/log_info') ?>">Log Export Info</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <?php }else if($session->get('report_type') == 'monthly' ){?>
        <li class="nav-item <?php if ($controller == 'main') {
                            echo 'active';
                        } ?>">
            <a class="nav-link <?php if ($controller == 'main' && ($method == 'monthly' || $method == '')) {
                                                echo 'active';
                                            } ?>" href="<?php echo base_url('main/monthly_period') ?>">
                <i class="fas fa-fw fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
           
        </li>

    <?php if( !empty($user_menu['REPORT']) ){?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if ($controller == 'report') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseReport">
            <i class="fas fa-fw fa-table"></i>
            <span>Report</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded menusideNav">
                <a class="collapse-item <?php if ($method == 'monthly') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/monthly') ?>">รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายเดือน</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <?php if( !empty($user_menu['IMPORT']) ){?>
    <li class="nav-item <?php if ($controller == 'import') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseImport" aria-expanded="true" aria-controls="collapseImport">
            <i class="fas fa-fw fa-upload"></i>
            <span>Import</span>
        </a>
        <div id="collapseImport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded menusideNav">
                
               <!--  <a class="collapse-item <?php if ( $controller == 'import' && $method == 'monthly') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('import/monthly') ?>">Monthly</a> -->
                <a class="collapse-item <?php if ( $controller == 'import' && $method == 'raw_monthly') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('import/raw_monthly') ?>">Monthly</a>
            </div>
        </div>
    </li>
    <?php } ?>
 
    <?php } ?>

    <!-- Nav Item - Tables -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>