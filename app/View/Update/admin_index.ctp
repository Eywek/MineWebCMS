<div class="row-fluid">

	<div class="span12">

		<div class="top-bar">
			<h3><i class="icon-calendar"></i> <?= $Lang->get('UPDATE') ?></h3>
		</div>

		<div class="well">
			<?= $this->Session->flash(); ?>
      
      <center>
        <p class="text-center"><?= $Lang->get('LAST_VERSION') ?> : <?= $Update->get_version() ?></p>
  			<button id="update" class="btn btn-large btn-lg btn-primary"><?= $Lang->get('UPDATE') ?></button>
        <button style="display:none;" id="stop_update" class="btn btn-large btn-lg btn-dangerr">Stop</button>
        <div id="update-msg"></div>
        <div class="progress progress-striped active" style="display:none;">
          <div class="bar" style="width: 40%;"></div>
        </div>
      </center>
			<br>

      <?php if(!empty($logs)) { ?>
        <hr>
        <h5 class="text-center"><?= $Lang->get('LOG_LAST_UPDATE') ?></h5>
        <div id="log-update">
          <p><b><?= $Lang->get('VERSION') ?></b> : <?= $logs['head']['version'] ?><br>
          <b><?= $Lang->get('CREATED') ?></b> : <?= $logs['head']['date'] ?></p>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><?= $Lang->get('ACTION') ?></th>
                <th><?= $Lang->get('STATE') ?></th>
                <th><?= $Lang->get('FILE') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($logs['update'])) { ?>
                <?php foreach ($logs['update'] as $k => $v) { ?>
                <tr>
                  <td><?= $Lang->get(key($v)) ?></td>
                  <td><?= $Lang->get(strtoupper($v[key($v)]['statut'])) ?></td>
                  <td><?= $v[key($v)]['arg'] ?></td>
                  <td></td>
                </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      <?php } ?>

		</div>

		</div>
</div>
<script>
  $('#update').click(function() {
    $('#update').attr('disabled', 'disabled');
    $('#update-msg').html('<br><div class="alert alert-info"><?= $Lang->get('ON_UPDATE') ?></div>').fadeIn(500);
    $('#stop_update').css('display', 'inline-block');
    $.ajax({
      xhr: function() {
            $('.progress').css('display', 'block');
            var xhr = new window.XMLHttpRequest();
            xhr.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    $('.progress .bar').css('width', '' + (100 * e.loaded / e.total) + '%');
                }
            });
            return xhr;
        }, 
      type: 'POST', 
      url: '<?= $this->Html->url(array('controller' => 'update', 'action' => 'update', 'admin' => true)) ?>', 
      data: {}, 
      complete: function(response, status, xhr) {
        data2 = response['responseText'].split("|");
        if(data2.indexOf('true') != -1) {
          $('#update-msg').empty().html('<div class="alert alert-success" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><b><?= $Lang->get('SUCCESS') ?> :</b> '+data2[0]+'</i></div>').fadeIn(500);
            $('#update').remove();
            $("#log-update").load("<?= $this->Html->url(array('controller' => 'update', 'action' => 'index', 'admin' => true)) ?> #log-update").fadeIn(500);
        } else if(data2.indexOf('false') != -1) {
          $('#update-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><b><?= $Lang->get('ERROR') ?> :</b> '+data2[0]+'</i></div>').fadeIn(500);
        }
        $('.progress').remove();
      }
    });
  });
  $('#stop_update').click(function() {
    $.ajax({
      type: 'POST', 
      url: '<?= $this->Html->url(array('controller' => 'update', 'action' => 'stop_update', 'admin' => true)) ?>', 
      data: {}, 
      complete: function(response, status, xhr) {
        data2 = response['responseText'].split("|");
        if(data2.indexOf('true') != -1) {
          location.reload();
        } else if(data2.indexOf('false') != -1) {
          $('#update-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><b><?= $Lang->get('ERROR') ?> :</b> <?= addslashes($Lang->get('INTERNAL_ERROR')) ?></i></div>').fadeIn(500);
        }
        $('.progress').remove();
      }
    });
  });
</script>