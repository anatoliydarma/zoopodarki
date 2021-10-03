<?php
namespace App\Http\Livewire\Dashboard;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class LogsViewer extends Component
{
    public $logs;
    public $availableDates;
    public $date = null;
    public $filename = '';
    public $selectedLog = null;
    public $selectedType = null;
    public $types = [
        [
            'name' => 'EMERGENCY',
            'class' => 'bg-pink-500',
        ],
        [
            'name' => 'ALERT',
            'class' => 'bg-red-600',
        ],
        [
            'name' => 'CRITICAL',
            'class' => 'bg-red-500',
        ],
        [
            'name' => 'ERROR',
            'class' => 'bg-red-400',
        ],
        [
            'name' => 'WARNING',
            'class' => 'bg-orange-500',
        ],
        [
            'name' => 'NOTICE',
            'class' => 'bg-yellow-500',
        ],
        [
            'name' => 'INFO',
            'class' => 'bg-green-500',
        ],
        [
            'name' => 'DEBUG',
            'class' => 'bg-blue-500',
        ],
    ];

    public function mount()
    {
        $this->availableDates = $this->getLogFileDates();
        $this->date = str_replace('.', '-', dataYmd(today()));
    }

    public function updatedDate()
    {
        $this->reset('selectedType');
    }

    protected function getLogFileDates()
    {
        $files = glob(storage_path('logs/laravel-*.log'));
        $files = array_reverse($files);
        $dates = [];


        if (!$files) {
            return [];
        }

        foreach ($files as $path) {
            $fileName = basename($path);
            preg_match('/(?<=laravel-)(.*)(?=.log)/', $fileName, $dtMatch);
            $funcDate = $dtMatch[0];
            array_push($dates, $funcDate);
        }

        return $dates;
    }

    public function getDate()
    {
        if (count($this->availableDates) == 0) {
            $this->dispatchBrowserEvent('toaster', ['message' => 'No log file found']);

            return  false;
        }

        if (!in_array($this->date, $this->availableDates)) {
            $this->dispatchBrowserEvent('toaster', ['message' => 'No log file found with selected date']);

            return  false;
        }

        $this->filename = 'laravel-' . $this->date . '.log';
    }

    public function getLogs()
    {
        $this->getDate();

        if (!is_file(storage_path('logs/' . $this->filename))) {
            return [];
        }

        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)/m";

        $content = file_get_contents(storage_path('logs/' . $this->filename));
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

        preg_match('/(?<=laravel-)(.*)(?=.log)/', $this->filename, $dtMatch);
        $this->date = $dtMatch[0];

        $funcLogs = collect();

        foreach ($matches as $key => $match) {
            $funcLogs->put(
                $key,
                ([
                    'id' => $key,
                    'timestamp' => $match['date'],
                    'env' => $match['env'],
                    'type' => $match['type'],
                    'message' => trim($match['message'])
                ])
            );
        }

        return $funcLogs;
    }

    public function openForm($id)
    {
        $funcLogs = $this->getLogs();
        $this->selectedLog = $funcLogs->firstWhere('id', $id);
    }

    public function closeForm()
    {
        $this->reset('selectedLog');
        $this->dispatchBrowserEvent('close');
    }

    public function delete()
    {
        if (!$this->filename) {
            return  $this->dispatchBrowserEvent('toaster', ['message' => 'File not found']);
        }

        $file = 'logs/' . $this->filename;

        if ($this->date === str_replace('.', '-', dataYmd(today()))) {
            if (File::exists(storage_path($file))) {
                file_put_contents(storage_path($file), '');
            }
            $this->dispatchBrowserEvent('toaster', ['message' => 'Log cleared.']);
        } elseif (File::exists(storage_path($file))) {
            File::delete(storage_path($file));

            $this->dispatchBrowserEvent('toaster', ['message' => 'Log deleted.']);
        } else {
            $this->dispatchBrowserEvent('toaster', ['message' => 'File not found']);
        }

        $this->availableDates = $this->getLogFileDates();
        $this->date = str_replace('.', '-', dataYmd(today()));
    }

    public function render()
    {
        $this->logs = $this->getLogs();

        if ($this->selectedType) {
            $this->logs = $this->logs->where('type', $this->selectedType);
        }

        return view('livewire.dashboard.logs-viewer')
        ->extends('dashboard.app')
        ->section('content');
    }
}