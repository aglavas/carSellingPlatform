<?php

namespace App\Nova\Actions;

use App\Interfaces\Exportable;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Spatie\SimpleExcel\SimpleExcelWriter;

class DataExport extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * @var bool
     */
    public $withoutActionEvents = false;

    /**
     * @var string
     */
    public $name = 'Download Excel';

    /**
     * @var SimpleExcelWriter
     */
    private $writer;

    /**
     * @var string
     */
    private $tempFile;

    /**
     * @var string
     */
    private $tempUrl;

    /**
     * @var string
     */
    private $exportFileName;

    /**
     * @var Collection|array
     */
    private $exportData;

    /**
     * @var int
     */
    private $counter = 0;

    /**
     * @var Exportable
     */
    private $model;

    /**
     * DataExport constructor.
     * @param string $fileName
     * @param string $fileNameSpace
     * @param Exportable $model
     */
    public function __construct(string $fileName, string $fileNameSpace, Exportable $model)
    {
        $user = Auth::user();

        $today = Carbon::now()->format('Y-m-d');

        $this->tempFile = public_path("storage/export/{$fileNameSpace}-{$today}-{$user->id}.xlsx");

        $this->tempUrl = url("storage/export/{$fileNameSpace}-{$today}-{$user->id}.xlsx");

        $this->writer = SimpleExcelWriter::create($this->tempFile);

        $this->exportFileName = $fileName;

        $this->model = $model;

        $this->exportData = $model->exportAdditionalData();
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        set_time_limit(300);
        ini_set('memory_limit', -1);

        foreach ($models as $model) {
            try {
                $row = $model->prepareExport($this->exportData);

                $this->writer->addRow($row);

                $this->counter++;
            } catch (\Exception $exception) {
                return Action::danger('Something went wrong! Error in data on row with id: ' . $model->id);
            }
        }
    }

    /**
     * @param ActionFields $fields
     * @param array $results
     * @return array|mixed
     */
    public function handleResult(ActionFields $fields, $results)
    {
        $request = Request::capture();

        $filters = null;

        if ($request->has('filters')) {
            $filters = json_decode(base64_decode($request->input('filters')));
        }

        activity('export_success')
            ->on($this->model)
            ->withProperties(['rows' => $this->counter, 'filters' => $filters])
            ->log('Export success.');

        return Action::download(
            $this->tempUrl,
            $this->exportFileName
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [

        ];
    }
}
