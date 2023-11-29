import(common.tpl)

.settings input[type="text"]|value = <?php 
	$_setting = '@@__name:\[(.*)\]__@@';
	echo $_POST['settings'][$_setting]  ?? Vvveb\get_setting('flat-rate-shipping', $_setting, null) ?? '@@__value__@@';
	//name="settings[setting-name] > get only setting-name
?>

.settings input[type="number"]|value = <?php 
	$_setting = '@@__name:\[(.*)\]__@@';
	echo $_POST['settings'][$_setting]  ?? Vvveb\get_setting('flat-rate-shipping', $_setting, null) ?? '@@__value__@@';
	//name="settings[setting-name] > get only setting-name
?>

.settings input[type="radio"]|addNewAttribute = <?php 
	$_setting = '@@__name:\[(.*)\]__@@';
	$_value = '@@__value__@@';
	
	if (isset($_POST['settings'][$_setting]) && ($_POST['settings'][$_setting] == $_value) ||
		(Vvveb\get_setting('flat-rate-shipping',$_setting, null) == $_value)  ||
		 '@@__checked__@@') { 
			echo 'checked';
	}
?>

.settings textarea = <?php 
	$_setting = '@@__name:\[(.*)\]__@@';
	echo $_POST['settings'][$_setting] ?? Vvveb\get_setting('flat-rate-shipping', $_setting, null) '@@__innerHTML__@@';
?>


@region_group = [data-v-region_group_id] [data-v-option]
@region_group|deleteAllButFirstChild

@region_group|before = <?php
$count = 0;
if(isset($this->region_group) && is_array($this->region_group)) {
	foreach ($this->region_group as $region_group_index => $region_group) {?>
	
	
	@region_group|innerText = $region_group
	@region_group|value	  = $region_group_index
	@region_group|addNewAttribute = <?php if (isset($this->region_group_id) && $region_group == $this->region_group_id) echo 'selected';?>
	
	
	@region_group|after = <?php 
		$count++;
	} 
}?>

@tax_type = [data-v-tax_type_id] [data-v-option]
@tax_type|deleteAllButFirstChild

@tax_type|before = <?php
$count = 0;
if(isset($this->tax_type) && is_array($this->tax_type)) {
	foreach ($this->tax_type as $tax_type_index => $tax_type) {?>
	
	
	@tax_type|innerText = $tax_type
	@tax_type|value	  = $tax_type_index
	@tax_type|addNewAttribute = <?php if (isset($this->tax_type_id) && $tax_type == $this->tax_type_id) echo 'selected';?>
	
	
	@tax_type|after = <?php 
		$count++;
	} 
}?>
