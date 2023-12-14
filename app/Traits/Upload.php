<?php

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


trait Upload
{
	public function makeDirectory($path)
	{
		if (file_exists($path)) return true;
		return mkdir($path, 0755, true);
	}

	public function removeFile($path)
	{
		return file_exists($path) && is_file($path) ? @unlink($path) : false;
	}

	public function fileUpload($file, $location, $driver = 'local', $fileName = null, $old = null)
	{
		$activeDisk = config('basic.default_file_driver');
		if (!empty($old)) {
			if (Storage::disk($driver)->exists($old)) {
				Storage::disk($driver)->delete($old);
				// Storage::disk($driver)->delete('thumb_' . $old);
			}
		}
		$file = new File($file);
		$path = Storage::disk($activeDisk)->putFileAs($location, $file, $fileName ?? $file->hashName());
		return $data = [
			'path' => $path,
			'driver' => $activeDisk,
		];
	}

	public function fileDelete($driver = 'local', $old)
	{
		if (!empty($old)) {
			if (Storage::disk($driver)->exists($old)) {
				Storage::disk($driver)->delete($old);
				// Storage::disk($driver)->delete('thumb_' . $old);
			}
		}
		return 0;
	}

}
