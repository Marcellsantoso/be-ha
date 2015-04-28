<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 1/30/15
 * Time: 10:24 AM
 */
class Tag extends WebService {

	const LIMIT_TAG = 10;

	public function getTag ()
	{
		$tagModel = new TagModel();
		$arrTag = $tagModel->getWhere('tag_count > 0 ORDER BY tag_count DESC LIMIT ' . $this::LIMIT_TAG);

		print_r(json_encode($arrTag));
	}

	public function updateTag ()
	{
		$arrCount = array ();

		$gallery = new GalleryModel();
		$arr = $gallery->getWhere('image_active = 1');
		foreach ($arr as $image) {
			$arrTag = explode(',', $image->image_tag);

			foreach ($arrTag as $tag) {
				if (str_replace(' ', '', $tag)) {
					$arrCount[$tag] = $arrCount[$tag] + 1;
				}
			}
		}

		// Empty all records first
		if (count($arrCount) > 0) {
			global $db;
			$tagModel = new TagModel();
			$db->query('TRUNCATE ' . $tagModel->table_name);
		}

		// Insert new records
		while ($count = current($arrCount)) {
			$tagModel = new TagModel();
			$tagModel->tag_word = key($arrCount);
			$tagModel->tag_count = $count;
			$tagModel->save();

			next($arrCount);
		}

		print_r('done');
	}
} 