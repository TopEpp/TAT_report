<?php $session = session();
$request = \Config\Services::request();
$controller =  $request->uri->getSegment(1);
$method =  $request->uri->getSegment(2);
?>
<style>
    .sidebar {
        width: 100%;
        min-height: 100vh;
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




    <li class="nav-item <?php if ($controller == 'main') {
                            echo 'active';
                        } ?>">
        <a class="nav-link" href="<?php echo base_url() ?>">
            <i class="fas fa-fw fa-dashboard"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Interface
    </div> -->

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
        <a class="nav-link" href="<?php echo base_url('import') ?>">
            <i class="fas fa-fw fa-folder"></i>
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


    <!-- Nav Item - Tables -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>