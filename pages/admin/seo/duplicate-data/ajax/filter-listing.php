<?
	$where=array();
	if ($_POST['market']) $where[] = "market = '{$_POST['market']}'";
	if ($_POST['market_name']) $where[] = "market_name = '{$_POST['market_name']}'";
	if ($_POST['volume']) $where[] = "volume = {$_POST['volume']}";
	if ($_POST['category']) $where[] = "category = '{$_POST['category']}'";
	if ($_POST['base']) $where[] = "base = '{$_POST['base']}'";
	if (!$listing) {
		$type == $_POST['type'];
		if ($type == 'paragraph') 
			$listing = aql::select("dup_sentence { id as sentence_id, sentence, volume order by sentence asc }",array('dup_sentence'=>array('where'=>$where)));
		else {
			$where [] = "volume > 0";
			$width = '30%';
			$listing = aql::select("dup_phrase_data { id as phrase_id, lower(phrase) as lower_phrase, phrase, volume order by volume DESC, phrase asc }", array('dup_phrase_data'=>array('where'=>$where)));
		}
	}
	$count = count($listing);
?>
    <input type="hidden" id="or" value="<?=$or?>" />
    <input type="hidden" id="type" value="<?=$type?>" />
	<input type="hidden" id="person_id" value="<?=PERSON_ID?>" />
    <fieldset style="width:<?=$width?>; border: solid 1px #CCCCCC; padding: 15px; float:left; margin-right:10px;">
    		<legend class="legend"><?=$type=='phrase'?'Phrase Part ':'Sentence #'?>1 (<?=$count?> Phrases)</legend>
<?
			if ($listing) foreach($listing as $data) {
?>
				<div style="width:55px; float:left; margin-right:5px; text-align:right;">(<?=$data['volume']?>)</div><div style="float:left;"> <input type="radio" name="phrase1" part="1" phrase="<?=$data['phrase']?>" phrase_id="<?=$data['phrase_id']?>" class="listing_radio" id="<?=$data['lower_phrase']?>" /> <label for="<?=$data['lower_phrase']?>"><?=$data['lower_phrase']?></label></div>
                <div class="clear"></div>
<?	
			}
?>
    	</fieldset>
