<?php

namespace App\Service;

use App\Interfaces\Exportable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\SimpleExcel\SimpleExcelWriter;

class DataExport
{
    /**
     * @var SimpleExcelWriter
     */
    private $writer;

    /**
     * @var string
     */
    private $tempFile;

    /**
     * @var Collection|array
     */
    private $exportData;

    /**
     * DataExport constructor.
     * @param Exportable $model
     */
    public function __construct(Exportable $model)
    {
        $user = Auth::user();

        $today = Carbon::now()->format('Y-m-d');

        $this->tempFile = public_path("storage/export/used-{$today}-{$user->id}.xlsx");

        $this->writer = SimpleExcelWriter::create($this->tempFile);

        $this->exportData = $model->exportAdditionalData();
    }

    /**
     * Export fetched collection
     *
     * @param Collection $models
     * @return string
     * @throws \Exception
     */
    public function export(Collection $models)
    {
        set_time_limit(300);
        ini_set('memory_limit', -1);

        foreach ($models as $model) {
            try {
                $row = $model->prepareExport($this->exportData);

                $this->writer->addRow($row);
            } catch (\Exception $exception) {
                throw new \Exception('Export failed with message:' . $exception->getMessage());
            }
        }

        return $this->tempFile;
    }
}
