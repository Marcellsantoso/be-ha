<?php
//set menu format domain, menuname. menu url
Registor::registerAdminMenu("Gallery", "Gallery", "Gallery/GalleryModel");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Gallery");

function rupiah ($uang)
{
	$uangasli = $uang;
	$rupiah = "";
	if ($uang < 0) {
		$uang = -$uang;
		$min = "-";
		$sred = "<span class='red'>";
		$sred2 = "</span>";
	}
	$panjang = Strlen($uang);
	while ($panjang > 3) {
		$rupiah = "." . substr($uang, -3) . $rupiah;
		$lebar = strlen($uang);
		$lebar = $lebar - 3;
		$uang = substr($uang, 0, $lebar);
		$panjang = strlen($uang);
	}
	$rupiah = $uang . $rupiah . ",-";

	return 'Rp. ' . $sred . $min . $rupiah . $sred2;
}

function getMainPic ($imgUrl)
{
	$arr = explode(',', $imgUrl);
	$image_url = array_diff_key($arr, array_unique(array_map('strtolower', $arr)));
	$image_url = implode('', $image_url);

	if(!$image_url){
		$imgUrl[0];
	}

	return $image_url;
}

function removeDuplicates ($arr)
{
	return array_unique($arr);
}

function formatUrl ($url)
{
	return str_replace(' ', '_', $url);
}
