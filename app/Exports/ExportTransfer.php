<?php

namespace App\Exports;

use App\Models\Transfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use StripeJS\Collection;

class ExportTransfer implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
	protected $data;
	protected $headers;
	protected $footer;

	public function __construct($data, $headers, $footer = null)
	{
		$this->data = $data;
		$this->headers = $headers;
		$this->footer = $footer;
	}

	public function collection()
	{
		return collect($this->data);
	}


	public function headings(): array
	{
		return $this->headers;
	}

	public function footer(): array
	{
		if ($this->footer !== null) {
			return $this->footer;
		}
		return [];
	}
}
