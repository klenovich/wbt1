import(common.tpl)

.settings input[name]|value = <?php 
	$_setting = '@@__name:\[(.*)\]__@@';
	echo $_POST['settings'][$_setting]  ?? Vvveb\get_setting('content-plugin', $_setting, '', $this->site_id);
	//name="settings[setting-name] > get only setting-name
?>

.settings textarea = <?php 
	$_setting = '@@__name:\[(.*)\]__@@';
	echo ($_POST['settings'][$_setting] ?? Vvveb\get_setting('content-plugin', $_setting, '', $this->site_id));
?>
