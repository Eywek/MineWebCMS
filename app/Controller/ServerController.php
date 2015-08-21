<?php

class ServerController extends AppController {

	public $components = array('Session');


	public function admin_link() {
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			$this->layout = "admin";
			 
			$this->set('title_for_layout',$this->Lang->get('LINK_SERVER'));

			$this->loadModel('Server');
			$servers = $this->Server->find('all');
			$this->set(compact('servers'));

			$this->set('timeout', $this->Configuration->get('server_timeout'));
		} else {
			$this->redirect('/');
		}
	}

	public function admin_test_call($key, $value) {
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			$this->autoRender = false;
			 
			echo '<pre>';
			var_dump($this->Server->call(array($key => $value)));
			echo '</pre>';
		} else {
			$this->redirect('/');
		}
	}

	public function admin_config() {
		$this->autoRender = false;
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			 
			$this->layout = null;
			if($this->request->is('ajax')) {
				if(!empty($this->request->data['timeout'])) {
					if(filter_var($this->request->data['timeout'], FILTER_VALIDATE_FLOAT)) {
						$this->Configuration->set('server_timeout', $this->request->data['timeout']);

						echo $this->Lang->get('SUCCESS_SAVE_TIMEOUT').'|true';
					} else {
						echo $this->Lang->get('INVALID_TIMEOUT').'|false';
					}
				} else {
					echo $this->Lang->get('COMPLETE_ALL_FIELDS').'|false';
				}
			} else {
				echo $this->Lang->get('NOT_POST' ,$language).'|false';
			}
		} else {
			$this->redirect('/');
		}
	}

	public function admin_link_ajax() {
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			 
			$this->layout = null;
			if($this->request->is('ajax')) {
				 
				if(!empty($this->request->data['host']) AND !empty($this->request->data['port']) AND !empty($this->request->data['name'])) {
					$secret_key = $this->Server->get('secret_key');
					if($secret_key !== false) {
						$timeout = $this->Configuration->get('server_timeout');
						if(!empty($timeout)) {
							if($this->Server->check('connection', array('host' => $this->request->data['host'], 'port' => $this->request->data['port'], 'timeout' => $timeout, 'secret_key' => $secret_key))) {
								$this->Configuration->set('server_state', 1);

								if(!empty($this->request->data['id'])) {
									$id = $this->request->data['id'];
								} else {
									$id = null;
								}

								$this->loadModel('Server');
								$this->Server->read(null, $id);
								$this->Server->set(array('name' => $this->request->data['name'], 'ip' => $this->request->data['host'], 'port' => $this->request->data['port']));
								$this->Server->save();

								$this->Configuration->set('server_secretkey', $secret_key);
								echo $this->Lang->get('SUCCESS_CONNECTION_SERVER').'|true';
							} else {
								$this->Configuration->set('server_state', 0);
								echo $this->Lang->get('SERVER_CONNECTION_FAILED').'|false';
							}
						} else {
							echo $this->Lang->get('NEED_CONFIG_SERVER_TIMEOUT').'|false';
						}
					} else {
						$this->Configuration->set('server_state', 0);
						echo $this->Lang->get('SERVER_CONNECTION_FAILED').'|false';
					}
				} else {
					echo $this->Lang->get('COMPLETE_ALL_FIELDS').'|false';
				}
			} else {
				echo $this->Lang->get('NOT_POST' ,$language).'|false';
			}
		} else {
			$this->redirect('/');
		}
	}

	public function admin_banlist() {
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			$this->layout = "admin";
			$list = $this->Server->call('getPlayersBanned');
			if($list != 'NEED_SERVER_ON') {
				$list = explode(',', $list['getPlayersBanned']);
			}
			if(isset($list[0]) AND $list[0] == "none") { $list = array(); }
			$this->set(compact('list'));
			$this->set('title_for_layout',$this->Lang->get('BANLIST'));
		} else {
			$this->redirect('/');
		}
	}

	public function admin_whitelist() {
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			$this->layout = "admin";
			$list = $this->Server->call('getPlayersWhitelisted');
			if($list != 'NEED_SERVER_ON') {
				$list = explode(',', $list['getPlayersWhitelisted']);
			}
			if(isset($list[0]) AND $list[0] == "none") { $list = array(); }
			$this->set(compact('list'));
			$this->set('title_for_layout',$this->Lang->get('WHITELIST'));
		} else {
			$this->redirect('/');
		}
	}

	public function admin_online() {
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			$this->layout = "admin";
			$list = $this->Server->call('getPlayerList');
			if($list != 'NEED_SERVER_ON') {
				$list = explode(',', $list['getPlayerList']);
			}
			if(isset($list[0]) AND $list[0] == "none") { $list = array(); }
			$this->set(compact('list'));
			$this->set('title_for_layout',$this->Lang->get('ONLINE'));
		} else {
			$this->redirect('/');
		}
	}

}