<?php require '../../config/lang.php' ?>
<div class="col-xs-12 col-sm-9">

    <div class="tab-content">
        <div class="tab-pane active" id="tabsleft-tab1">
            <h1><?= $Lang->get('STEP_1') ?></h1>
            <p><?= $Lang->get('DESC_STEP_1') ?></p>
            <br>
            <p>
                <form>
                    <div class="form-group">
                        <label><?= $Lang->get('HOST') ?></label>
                        <input type="text" class="form-control" value="<?= $host ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label><?= $Lang->get('DATABASE') ?></label>
                        <input type="text" class="form-control" value="<?= $database ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label><?= $Lang->get('LOGIN_BDD') ?></label>
                        <input type="text" class="form-control"  value="<?= $login ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label><?= $Lang->get('PASSWORD') ?></label>
                        <input type="password" class="form-control" value="**********" disabled>
                    </div>
                    <ul class="pager wizard">
                        <li class="previous disabled"><a href="javascript:;"><?= $Lang->get('PREVIOUS') ?></a></li>
                        <li class="next" style="display: inline;"><a id="tabsleft-link" href="javascript:;"><?= $Lang->get('NEXT') ?></a></li>
                        <li class="next finish hidden" style="display: none;"><a href="javascript:;"><?= $Lang->get('END') ?></a></li>
                    </ul>
                </form>
            </p>
        </div>
        <div class="tab-pane" id="tabsleft-tab2">
            <h1><?= $Lang->get('STEP_2') ?></h1>
            <p><?= $Lang->get('DESC_STEP_2') ?></p>
            <p>
                <form id="step2">
                    <div class="ajax-msg-step2"></div>
                    <div class="form-group">
                        <label><?= $Lang->get('SERVER_HOST') ?></label>
                        <input type="text" class="form-control" name="host"<?php if(!empty($server_host)) { echo ' value="'.$server_host.'"'; } ?> placeholder="Ex: 127.0.0.1">
                    </div>
                    <div class="form-group">
                        <label><?= $Lang->get('PORT') ?></label>
                        <input type="text" class="form-control" name="port"<?php if(!empty($port)) { echo ' value="'.$port.'"'; } ?> placeholder="Ex: 8080">
                    </div>
                    <div class="form-group">
                        <label><?= $Lang->get('TIMEOUT') ?> <small><?= $Lang->get('IN_SECONDS') ?> </small></label>
                        <input type="text" class="form-control" name="timeout"<?php if(!empty($timeout)) { echo ' value="'.$timeout.'"'; } ?> placeholder="Ex: 3">
                    </div>
                    <?php if(!empty($server_host)) { ?>
                        <input type="hidden" name="step2" value="true">
                    <?php } else { ?>
                        <input type="hidden" name="step2" value="" id="skip">
                    <?php } ?>
                    <ul class="pager wizard">
                        <li class="previous disabled"><a href="javascript:;"><?= $Lang->get('PREVIOUS') ?></a></li>
                        <?php if(empty($server_host)) { ?>
                            <li class="next" style="display: inline;"><a onClick="$('#skip').val('true');" href="javascript:;"><?= $Lang->get('SKIP') ?></a></li>
                        <?php } ?>
                        <li class="next" style="display: inline;"><a id="tabsleft-link" href="javascript:;"><?= $Lang->get('NEXT') ?></a></li>
                        <li class="next finish hidden" style="display: none;"><a href="javascript:;"><?= $Lang->get('END') ?></a></li>
                    </ul>
                </form>
            </p>
        </div>
        <div class="tab-pane" id="tabsleft-tab3">
            <h1><?= $Lang->get('STEP_3') ?></h1>
            <p><?= $Lang->get('DESC_STEP_3') ?></p>
            <p>
                <form id="step3">
                    <div class="ajax-msg-step3"></div>
                    <div class="form-group">
                        <label><?= $Lang->get('PSEUDO') ?></label>
                        <input type="text" class="form-control" name="pseudo"<?php if(!empty($admin_pseudo)) { echo ' value="'.$admin_pseudo.'"'; } ?> placeholder="<?= $Lang->get('ENTER_PSEUDO') ?>">
                      </div>
                      <div class="form-group">
                        <label><?= $Lang->get('PASSWORD') ?></label>
                        <input type="password" class="form-control" name="password"<?php if(!empty($admin_password)) { echo ' value="*********"'; } ?> placeholder="<?= $Lang->get('ENTER_PASSWORD') ?>">
                      </div>
                      <div class="form-group">
                        <label><?= $Lang->get('PASSWORD_CONFIRMATION') ?></label>
                        <input type="password" class="form-control" name="password_confirmation"<?php if(!empty($admin_password)) { echo ' value="*********"'; } ?> placeholder="<?= $Lang->get('ENTER_PASSWORD_CONFIRMATION') ?>">
                      </div>
                      <div class="form-group">
                        <label><?= $Lang->get('EMAIL') ?></label>
                        <input type="email" class="form-control" name="email"<?php if(!empty($admin_email)) { echo ' value="'.$admin_email.'"'; } ?> placeholder="<?= $Lang->get('ENTER_EMAIL') ?>">
                      </div>
                       <?php if(!empty($admin_pseudo)) { ?>
                            <input type="hidden" name="step3" value="true">
                        <?php } ?>
                        <div id="input"></div>
                        <li class="next finish hidden" style="display: none;"><a href="javascript:;"><?= $Lang->get('END') ?></a></li>
                                        <ul class="pager wizard">
                        <li class="previous disabled"><a href="javascript:;"><?= $Lang->get('PREVIOUS') ?></a></li>
                        <li class="next" style="display: inline;"><a id="tabsleft-link" href="javascript:;"><?= $Lang->get('NEXT') ?></a></li>
                        <li class="next finish hidden" style="display: none;"><a href="javascript:;"><?= $Lang->get('END') ?></a></li>
                    </ul>
                </form>
            </p>
        </div>
        <div class="tab-pane" id="tabsleft-tab4">
            <h1><?= $Lang->get('STEP_4') ?></h1>
            <div class="alert alert-success"><?= $Lang->get('DESC_STEP_4') ?></div>
            <p>
                <a href="<?= $this->Html->url(array('controller' => 'install', 'action' => 'end')) ?>" class="btn btn-block btn-success"><?= $Lang->get('USE_CMS') ?></a>
                <ul class="pager wizard">
                    <li class="previous disabled"><a href="javascript:;"><?= $Lang->get('PREVIOUS') ?></a></li>
                    <li class="next" style="display: inline;"><a id="tabsleft-link" href="javascript:;"><?= $Lang->get('NEXT') ?></a></li>
                </ul>
            </p>
        </div>
        
        <div class="progress">
            <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%"></div>
        </div>

        
    </div>
          
</div><!-- /.col-xs-12 main -->