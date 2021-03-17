<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function field($field_id)
{
  $CI = &get_instance();
  return $CI->db->get_where('Mstr_Fields', array('field_id' => $field_id))->row_array();
}

function get_mahasiswa_by_nim($nim)
{
  $CI = &get_instance();
  $query = $CI->db->get_where('V_Mahasiswa', array('STUDENTID' => $nim))->row_array();
  echo $query['FULLNAME'];
}

//menampilkan kategori keterangan surat
function generate_form_field($field_id, $pengajuan_id, $pengajuan_status, $fungsi_upload)
{
  $id = $field_id;
?>
  <link href="<?= base_url() ?>public/plugins/dm-uploader/dist/css/jquery.dm-uploader.min.css" rel="stylesheet">
  <?php

  $CI = &get_instance();
  $fields = $CI->db->select('mf.*')->from('Mstr_Fields mf')
    ->where(array('mf.field_id' => $id))
    ->get()->row_array();

  $field_key = ($fields) ? $fields['key'] : '';

  $value = $CI->db->select('fv.value, fv.verifikasi')->from('Tr_Field_Value fv')
    ->where(array('field_id' => $field_id, 'pengajuan_id' => $pengajuan_id))
    ->get()->row_array();


  $field_value = ($value) ? $value['value'] : '0';
  $verifikasi = ($value) ? $value['verifikasi'] : '0';

  if ($fields['type'] == 'file') { ?>

    <?php
    $image_id = (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;

    $image = $CI->db->select('*')->from('Tr_Media')
      ->where(array('id' => $image_id))->get()->row_array();

    if ($image) {
      $thumb = $image['file'];
      $image = base_url('public/dist/img/document.png');
      $exploded = explode("/", $thumb);
      $file_name = $exploded[2];
    } else {
      echo $image = '';
      echo  $thumb = '';
      $file_name = '';
    }

    ?>
    <link href="<?= base_url() ?>public/plugins/dm-uploader/dist/css/jquery.dm-uploader.min.css" rel="stylesheet">

    <!-- Our markup, the important part here! -->

    <?php if (validation_errors()) {
      //cetak value yang sudah ada
      if (set_value('dokumen[' . $id . ']')) {
        echo '';
      }
      echo "ada error";
    } else {
      echo  $field_value;
    }
    ?>


    <div id="drag-and-drop-zone" class="dm-uploader <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?> p-3 <?= ($field_value) ? "d-none" : ""; ?>">
      <h5 class="mb-2 mt-2 text-muted">Seret &amp; lepaskan berkas di sini</h5>

      <div class="btn btn-primary btn-block mb-2">
        <span>Atau klik untuk mengunggah</span>
        <input type="file" title='Klik untuk mengunggah' />
      </div>
    </div><!-- /uploader -->
    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

    <input type="hidden" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" class="id-dokumen" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" />

    <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
      <li class="text-muted text-center empty">Belum ada file yang diupload.</li>
    </ul>

    <script src="<?= base_url() ?>/public/plugins/dm-uploader/dist/js/jquery.dm-uploader.min.js"></script>
    <script>
      /*
       * Some helper functions to work with our UI and keep our code cleaner
       */

      // Adds an entry to our debug area
      function ui_add_log(message, color) {
        var d = new Date();

        var dateString = (('0' + d.getHours())).slice(-2) + ':' +
          (('0' + d.getMinutes())).slice(-2) + ':' +
          (('0' + d.getSeconds())).slice(-2);

        color = (typeof color === 'undefined' ? 'muted' : color);

        var template = $('#debug-template').text();
        template = template.replace('%%date%%', dateString);
        template = template.replace('%%message%%', message);
        template = template.replace('%%color%%', color);

        $('#debug').find('li.empty').fadeOut(); // remove the 'no messages yet'
        $('#debug').prepend(template);
      }

      // Creates a new file and add it to our list
      function ui_multi_add_file(id, file) {
        var template = $('#files-template').text();

        console.log(file);

        template = template.replace('%%filename%%', file.name);
        template = $(template);
        template.prop('id', 'uploaderFile' + id);
        template.data('file-id', id);

        $('#files').find('li.empty').hide(); // remove the 'no files yet'
        $('#files').prepend(template);
      }

      // Changes the status messages on our list
      function ui_multi_update_file_status(id, status, message) {
        $('#uploaderFile' + id).find('span').html(message).prop('class', 'status text-' + status);
      }

      // Updates a file progress, depending on the parameters it may animate it or change the color.
      function ui_multi_update_file_progress(id, percent, color, active) {
        color = (typeof color === 'undefined' ? false : color);
        active = (typeof active === 'undefined' ? true : active);

        var bar = $('#uploaderFile' + id).find('div.progress-bar');

        bar.width(percent + '%').attr('aria-valuenow', percent);
        bar.toggleClass('progress-bar-striped progress-bar-animated', active);

        if (percent === 0) {
          bar.html('');
        } else {
          bar.html(percent + '%');
        }

        if (color !== false) {
          bar.removeClass('bg-success bg-info bg-warning bg-danger');
          bar.addClass('bg-' + color);
        }
      }
      $(function() {
        /*
         * For the sake keeping the code clean and the examples simple this file
         * contains only the plugin configuration & callbacks.
         * 
         * UI functions ui_* can be located in: demo-ui.js
         */
        $('#drag-and-drop-zone').dmUploader({ //
          url: '<?= base_url($fungsi_upload); ?>/doupload',
          maxFileSize: 3000000, // 3 Megs 
          extFilter: ['jpg', 'jpeg', 'png', 'pdf'],
          onDragEnter: function() {
            // Happens when dragging something over the DnD area
            this.addClass('active');
          },
          onDragLeave: function() {
            // Happens when dragging something OUT of the DnD area
            this.removeClass('active');
          },
          onInit: function() {
            // Plugin is ready to use
          },
          onComplete: function() {
            // All files in the queue are processed (success or error)
          },
          onNewFile: function(id, file) {
            // When a new file is added using the file selector or the DnD area
            ui_multi_add_file(id, file);
          },
          onBeforeUpload: function(id) {
            // about tho start uploading a file
            ui_multi_update_file_status(id, 'uploading', '<img width="40px" height="" src="<?= base_url() ?>/public/dist/img/spinners.gif" />');
            ui_multi_update_file_progress(id, 0, '', true);
          },
          onUploadCanceled: function(id) {
            // Happens when a file is directly canceled by the user.
            ui_multi_update_file_status(id, 'warning', 'Canceled by User');
            ui_multi_update_file_progress(id, 0, 'warning', false);
          },
          onUploadProgress: function(id, percent) {
            // Updating file progress
            ui_multi_update_file_progress(id, percent);
          },
          onUploadSuccess: function(id, data) {
            // A file was successfully uploaded
            ui_multi_update_file_status(id, 'success', '<i class="fas fa-check-circle"></i>');
            ui_multi_update_file_progress(id, 100, 'success', false);

            var response = JSON.stringify(data);
            var obj = JSON.parse(response);

            $('.id-dokumen').val(obj.id);
            $('#drag-and-drop-zone').fadeOut('400');
            $('.deleteUser').removeClass('d-none', '3000');
            var button = "<a class='btn btn-sm btn-warning' target='_blank' href='<?= base_url(); ?>" + obj.orig + "'><i class='fas fa-eye'></i> Lihat</a> <a href='<?= base_url($fungsi_upload); ?>/hapus_file/' class='deleteUser btn btn-sm btn-danger' data-id='" + obj.id + "'> <i class='fas fa-pencil-alt'></i> Ganti</a>";
            $('.buttonedit').prepend(button);

          },
          onUploadError: function(id, xhr, status, message) {
            ui_multi_update_file_status(id, 'danger', message);
            ui_multi_update_file_progress(id, 0, 'danger', false);
          },
          onFileExtError: function(id, file) {
            $('#files').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File tidak didukung').removeClass('text-muted').addClass('text-danger');
          },
          onFileSizeError: function(id, file) {

            $('#files').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File terlalu besar').removeClass('text-muted').addClass('text-danger');

          }
        });
      });
      $('body').on('click', 'a.deleteUser', function(e) {
        e.preventDefault();
        var href = $(this).attr("href");
        var ele = $(this).parents('.media');

        $.ajax({
          url: href,
          type: "POST",
          cache: false,
          data: {
            id: $(this).attr("data-id")
          },
          success: function(dataResult) {
            // alert(dataResult);
            var dataResult = JSON.parse(dataResult);
            if (dataResult.statusCode == 200) {
              ele.fadeOut().remove();
              $('#files').find('div.empty').fadeIn();
              $('#drag-and-drop-zone').fadeIn('400');
              $('#files').find('li.empty').show();
              $('.id-dokumen').val('');
            }
          }
        });

      });
    </script>


    <!-- File item template -->
    <script type="text/html" id="files-template">
      <li class="media">
        <div class="media-body mb-1">
          <p class="mb-2">
            <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>

          </p>

          <div class="buttonedit"></div>

          <!-- <div class="progress mb-2">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            </div>
          </div> -->
        </div>
      </li>
    </script>

  <?php } elseif ($fields['type'] == 'text') {  ?>

    <input type="text" class="form-control <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($pengajuan_status == 1 || $pengajuan_status == 2 || $pengajuan_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?> />
    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

  <?php } elseif ($fields['type'] == 'textarea') {  ?>

    <textarea class="form-control <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($pengajuan_status == 1 &&  $verifikasi == 1 || $pengajuan_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?>><?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?></textarea>
    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

  <?php } elseif ($fields['type'] == 'date_range') {  ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>

    <script type="text/javascript" src="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.css" />

    <input type="text" class="form-control" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($pengajuan_status == 1 && $verifikasi == 0 || $pengajuan_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?> />

    <script type="text/javascript">
      $(function() {

        $('#input-<?= $id; ?>').daterangepicker({
          autoUpdateInput: false,
          locale: {
            cancelLabel: 'Clear'
          }
        });

        $('#input-<?= $id; ?>').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('#input-<?= $id; ?>').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
        });

      });
    </script>

    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

  <?php } elseif ($fields['type'] == 'ta') { ?>
    <select class="form-control
<?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> 
<?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?>" name="dokumen[<?= $id; ?>]" id="input-<?= $id; ?>">
      <option value=""> -- Pilih Tahun Akademik -- </option>
      <?php
      $cur_year = date("Y");
      $cur_semester = (date("n") <= 6) ?  $cur_year - 1 : $cur_year;
      for ($x = $cur_semester; $x <= $cur_year + 1; $x++) {
        $value_select = sprintf("%d / %d", $x, $x + 1); ?>
        <option value="<?= $value_select; ?>" <?= (validation_errors()) ? set_select('dokumen[' . $id . ']', $value_select) : ""; ?> <?= ($field_value == $value_select) ? "selected" : ""; ?>><?= $x; ?> / <?= $x + 1; ?></option>
      <?php  }
      ?>
    </select>
    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

  <?php } elseif ($fields['type'] == 'date') { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <input type="text" class="form-control <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($pengajuan_status == 1 && $verifikasi == 0 || $pengajuan_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?> />
    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      $(function() {
        $("#input-<?= $id; ?>").datepicker();
      });
    </script>
  <?php } elseif ($fields['type'] == 'number') { ?>
    <input type="number" class="form-control <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($pengajuan_status == 1 || $pengajuan_status == 2 || $pengajuan_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?> />
    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

  <?php } elseif ($fields['type'] == 'multi_select_anggota') { ?>
    <?php
    $CI = &get_instance();
    $query = $CI->db->query("SELECT value FROM Tr_Field_Value WHERE pengajuan_id = $pengajuan_id AND field_id = $id")->row_array();
    $anggota_string = $query['value'];
    $anggota_array = explode(",", $anggota_string);
    ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <select class="js-data-example-ajax form-control form-control-lg <?= $fields['key']; ?> form-control <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($pengajuan_status == 4)) ? 'is-invalid' : ''; ?>" <?= ($pengajuan_status == 1 && $verifikasi == 0 || $pengajuan_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?> value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" name="dokumen[<?= $id; ?>][]" multiple>
      <?php
      if ($pengajuan_status == 1 && $verifikasi == 0 || $pengajuan_status == 4 && $verifikasi == 0) {
      } else {
      ?>
        <?php foreach ($anggota_array as $anggota) { ?>
          <option value="<?= $anggota; ?>"><?php get_mahasiswa_by_nim($anggota); ?></option>
        <?php } ?>
      <?php
      }
      ?>
    </select>
    <span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
        <?php
        if ($pengajuan_status == 1 && $verifikasi == 0 || $pengajuan_status == 4 && $verifikasi == 0) {
        } else {
        ?>
          var selectedValuesTest = [
            <?php foreach ($anggota_array as $anggota) {
              echo '"' . $anggota . '"' . ',';
            } ?>
          ];
        <?php
        }
        ?>
        $('.js-data-example-ajax').select2({
          ajax: {
            url: '<?= base_url('mahasiswa/pengajuan/getanggota'); ?>',
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function(params) {
              return {
                search: params.term,
              }
            },
            processResults: function(data) {
              return {
                results: data
              };
            },
            cache: true
          },
          placeholder: 'Tuliskan NIM atau Nama Mahasiswa',
          minimumInputLength: 3,
          // templateResult: formatRepo,
          // templateSelection: formatRepoSelection
        });
        $('.js-data-example-ajax').val(selectedValuesTest).trigger('change');
      });
    </script>



<?php
  } // endif file 
}

function fileUploaderModal()
{
}





function get_file_name($file_dir = 0)
{
  $file_name = explode("/", $file_dir);
  echo $file_name[2];
}

function get_meta_name($key)
{
  $CI = &get_instance();
  $name = $CI->db->select("kat_keterangan_surat")
    ->from('kat_keterangan_surat')
    ->where(array('key' => $key))
    ->get()
    ->row_array()['kat_keterangan_surat'];

  return $name;
}
