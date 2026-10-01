<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php
$sections = [
  'group' => ['title' => 'สิทธิ์ตามรหัสหน่วยงาน', 'keyLabel' => 'รหัสหน่วยงาน', 'keyCol' => 'GROUP_ID', 'rows' => $group],
  'user'  => ['title' => 'สิทธิ์รายบุคคล', 'keyLabel' => 'Username', 'keyCol' => 'USERNAME', 'rows' => $user],
];
?>
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-info small">
      <b>ลำดับการใช้สิทธิ์ตอน Login ผ่าน AD:</b>
      ระบบหา <b>รหัสหน่วยงาน</b> (title ใน AD) ก่อน → ถ้าไม่พบจึงหา <b>Username</b> → ถ้าไม่พบทั้งคู่ได้สิทธิ์ Dashboard + Report<br>
      ดังนั้นสิทธิ์รายบุคคลจะ<b>ไม่มีผล</b>ถ้าหน่วยงานของผู้ใช้คนนั้นมีอยู่ในตารางหน่วยงานแล้ว ·
      การแก้ไขจะมีผลเมื่อผู้ใช้ <b>Login ใหม่</b>
    </div>
  </div>
</div>

<?php foreach ($sections as $type => $sec) { ?>
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header">
        <?= esc($sec['title']) ?> <span class="text-muted small">(<?= count($sec['rows']) ?> รายการ)</span>
        <?php if ($canManage) { ?>
          <button type="button" class="btn btn-primary btn-sm float-right rounded" onclick="managePermission('<?= $type ?>')">
            <i class="fa fa-plus"></i> เพิ่ม<?= esc($sec['keyLabel']) ?>
          </button>
        <?php } ?>
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered permission-table" id="table_<?= $type ?>">
          <thead>
            <tr>
              <th><?= esc($sec['keyLabel']) ?></th>
              <?php foreach ($flags as $flag) { ?>
                <th width="11%" class="text-center"><?= ucfirst(strtolower($flag)) ?></th>
              <?php } ?>
              <?php if ($canManage) { ?><th width="12%"></th><?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sec['rows'] as $d) {
              $key = (string) $d[$sec['keyCol']];
              $rowFlags = [];
              foreach ($flags as $flag) { $rowFlags[$flag] = !empty($d[$flag]); }
            ?>
              <tr>
                <td><?= esc($key) ?></td>
                <?php foreach ($flags as $flag) { ?>
                  <td align="center" data-order="<?= $rowFlags[$flag] ? 1 : 0 ?>"><?php if ($rowFlags[$flag]) { echo '<i class="fa fa-check" style="color:green"></i>'; } ?></td>
                <?php } ?>
                <?php if ($canManage) { ?>
                  <td align="center" class="text-nowrap">
                    <button type="button" class="btn btn-primary btn-sm" title="แก้ไข"
                      data-key="<?= esc($key, 'attr') ?>" data-flags="<?= esc(json_encode($rowFlags), 'attr') ?>"
                      onclick="managePermission('<?= $type ?>', this)"><i class="fa fa-pen"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" title="ลบ"
                      data-key="<?= esc($key, 'attr') ?>"
                      onclick="deletePermission('<?= $type ?>', this)"><i class="fa fa-trash"></i></button>
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php if ($canManage) { ?>
<!-- Modal -->
<div class="modal fade" id="managePermission" tabindex="-1" role="dialog" aria-labelledby="permissionModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="permissionModalTitle">จัดการสิทธิ์</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPermission" onsubmit="savePermission(); return false;">
          <input type="hidden" name="type" id="perm_type">
          <input type="hidden" name="original_key" id="perm_original_key">
          <div class="form-group">
            <label for="perm_key" class="form-label"><span id="perm_key_label"></span> <span class="text-danger">*</span></label>
            <input type="text" name="key" id="perm_key" class="form-control" autocomplete="off">
            <small id="perm_key_hint" class="form-text text-muted"></small>
            <div id="valid_perm_key" class="text-danger d-none pt-1"></div>
          </div>
          <label class="form-label">สิทธิ์เมนู</label>
          <?php foreach ($flags as $flag) { ?>
            <div class="custom-control custom-checkbox">
              <input type="hidden" name="flags[<?= $flag ?>]" value="0">
              <input type="checkbox" class="custom-control-input perm-flag" name="flags[<?= $flag ?>]" value="1" id="perm_flag_<?= $flag ?>" data-flag="<?= $flag ?>">
              <label class="custom-control-label" for="perm_flag_<?= $flag ?>"><?= ucfirst(strtolower($flag)) ?></label>
            </div>
          <?php } ?>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="btnSavePermission" onclick="savePermission()">บันทึก</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
  const PERMISSION_TYPES = {
    group: { label: 'รหัสหน่วยงาน', hint: 'ตัวเลขตาม title ใน AD เช่น 410202', pattern: /^\d{1,10}$/, error: 'รหัสหน่วยงานต้องเป็นตัวเลข 1-10 หลัก' },
    user:  { label: 'Username', hint: 'Username AD (sAMAccountName) เช่น firstname.last', pattern: /^[A-Za-z0-9._-]{1,200}$/, error: 'Username ใช้ได้เฉพาะ a-z 0-9 . _ - (ไม่เกิน 200 ตัวอักษร)' }
  };
  const DEFAULT_FLAGS = ['DASHBOARD', 'REPORT'];

  $(document).ready(function() {
    $('.permission-table').DataTable({
      order: [[0, 'asc']],
      pageLength: 25,
      columnDefs: [{ targets: -1, orderable: <?= $canManage ? 'false' : 'true' ?> }],
      language: {
        "lengthMenu": "แสดง _MENU_ รายการ",
        "search": "ค้นหา:",
        "zeroRecords": "ไม่มีข้อมูล",
        "info": "รายการที่ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
        "infoEmpty": "ไม่มีข้อมูล",
        "infoFiltered": "(กรองจาก _MAX_ รายการ)",
        "paginate": { "first": "First", "last": "Last", "next": "ถัดไป", "previous": "ก่อนหน้า" },
      }
    });
  });

  function managePermission(type, btn) {
    const conf = PERMISSION_TYPES[type];
    const isEdit = !!btn;
    const key = isEdit ? String($(btn).data('key')) : '';
    const flags = isEdit ? $(btn).data('flags') : null;

    $('#perm_type').val(type);
    $('#perm_original_key').val(key);
    $('#perm_key').val(key);
    $('#perm_key_label').text(conf.label);
    $('#perm_key_hint').text(conf.hint);
    $('#permissionModalTitle').text((isEdit ? 'แก้ไข' : 'เพิ่ม') + 'สิทธิ์' + (type === 'group' ? 'ตามรหัสหน่วยงาน' : 'รายบุคคล'));
    $('#valid_perm_key').addClass('d-none');
    $('.perm-flag').each(function() {
      const flag = $(this).data('flag');
      $(this).prop('checked', isEdit ? !!flags[flag] : DEFAULT_FLAGS.includes(flag));
    });

    $('#managePermission').modal('show');
  }

  function showPermissionError(message) {
    Swal.fire({ icon: 'error', title: 'ไม่สำเร็จ', text: message, confirmButtonColor: '#007c83' });
  }

  function permissionAjax(url, data, onSuccess) {
    $.ajax({
      method: 'POST',
      url: base_url + url,
      data: data,
      dataType: 'json',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      success: function(res) {
        if (res && res.status === 'success') {
          onSuccess(res);
        } else {
          showPermissionError((res && res.message) || 'เกิดข้อผิดพลาด');
        }
      },
      error: function(xhr) {
        const res = xhr.responseJSON;
        showPermissionError((res && res.message) || 'เกิดข้อผิดพลาด (' + xhr.status + ')');
      },
      complete: function() {
        $('#btnSavePermission').prop('disabled', false);
      }
    });
  }

  function reloadWithToast(title) {
    Swal.fire({
      position: 'top-end', icon: 'success', iconColor: '#007c83',
      title: title, showConfirmButton: false, timer: 1500
    }).then(() => { window.location.reload() });
  }

  function savePermission() {
    const conf = PERMISSION_TYPES[$('#perm_type').val()];
    const key = $.trim($('#perm_key').val());
    $('#perm_key').val(key);

    if (!conf.pattern.test(key)) {
      $('#valid_perm_key').text('*' + conf.error).removeClass('d-none');
      return;
    }
    $('#valid_perm_key').addClass('d-none');
    $('#btnSavePermission').prop('disabled', true);

    permissionAjax('/setting/savePermission', $('#formPermission').serialize(), function(res) {
      $('#managePermission').modal('hide');
      reloadWithToast(res.message);
    });
  }

  function deletePermission(type, btn) {
    const key = String($(btn).data('key'));
    Swal.fire({
      title: 'ยืนยันการลบสิทธิ์?',
      text: PERMISSION_TYPES[type].label + ': ' + key,
      icon: 'warning',
      showCancelButton: true,
      iconColor: '#ffa500',
      confirmButtonColor: '#007c83',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ตกลง',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        permissionAjax('/setting/deletePermission', { type: type, key: key }, function(res) {
          reloadWithToast(res.message);
        });
      }
    });
  }
</script>
<?= $this->endSection() ?>
