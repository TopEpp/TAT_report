<?php $session = session();
$request = \Config\Services::request();
$controller =  $request->uri->getSegment(1);
$method =  $request->uri->getSegment(2);
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
</style>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12" style="text-align:center; ">
            <div class="sidebar-brand-icon ">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('public/img/tat.png'); ?>" alt="" width="100px"></a>
            </div>
        </div>
    </div>



    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <?php if($session->get('report_type') == 'daily'){ ?>
    
    <li class="nav-item <?php if ($controller == 'main') {
                            echo 'active';
                        } ?>">
        <a class="nav-link <?php if ($controller == 'main' && ($method == 'daily' || $method == '')) {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/daily') ?>">
            <i class="fas fa-fw fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
       
    </li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if ($controller == 'report') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseReport">
            <i class="fas fa-fw fa-table"></i>
            <span>Report</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if ($method == 'nation') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/nation') ?>">รายงานจำนวนนักท่องเที่ยวรายสัญชาติ</a>
                <a class="collapse-item <?php if ($method == 'port') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/port') ?>">รายงานจำนวนนักท่องเที่ยวรายด่าน</a>
                <a class="collapse-item <?php if ($method == 'nation_compare') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/nation_compare') ?>">รายงานเปรียบเทียบจำนวนนักท่องเที่ยวรายสัญชาติ</a>
                <a class="collapse-item <?php if ($method == 'port_compare') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/port_compare') ?>">รายงานเปรียบเทียบจำนวนนักท่องเที่ยวรายด่าน</a>
                <a class="collapse-item <?php if ($method == 'market') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/market') ?>">รายงานจำนวนนักท่องเที่ยวจำแนกรายรายตลาด</a>
                <a class="collapse-item <?php if ($method == 'nation_daily') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/nation_daily') ?>">รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายสัญชาติ</a>
                <a class="collapse-item <?php if ($method == 'port_daily') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/port_daily') ?>">รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายด่าน</a>
               
            </div>
        </div>
    </li>

    <li class="nav-item <?php if ($controller == 'import') {
                            echo 'active';
                        } ?>">

        <a class="nav-link  <?php if ( $controller == 'import' && ($method == 'index' || $method == '')) {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('import') ?>"> 
                                        <i class="fas fa-fw fa-upload"></i>
            <span>Import</span></a>

       
    </li>


    <li class="nav-item <?php if ($controller == 'setting') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
        <div id="collapseSetting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
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
            </div>
        </div>
    </li>
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

        <!-- <li class="nav-item <?php if ($controller == 'main') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMain" aria-expanded="true" aria-controls="collapseMain">
            <i class="fas fa-fw fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
        <div id="collapseMain" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if ($controller == 'main' && $method == 'monthly') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/monthly') ?>">Monthly</a>
                <a class="collapse-item <?php if ($controller == 'main' && $method == 'monthly_period') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('main/monthly_period') ?>">Monthly Period</a>
            </div>
        </div>
    </li> -->


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if ($controller == 'report') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseReport">
            <i class="fas fa-fw fa-table"></i>
            <span>Report</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if ($method == 'monthly') {
                                            echo 'active';
                                        } ?>" href="<?php echo base_url('report/monthly') ?>">รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายเดือน</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?php if ($controller == 'import') {
                            echo 'active';
                        } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseImport" aria-expanded="true" aria-controls="collapseImport">
            <i class="fas fa-fw fa-upload"></i>
            <span>Import</span>
        </a>
        <div id="collapseImport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                
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

    <!-- Nav Item - Tables -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>