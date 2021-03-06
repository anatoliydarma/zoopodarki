<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Product1C;
use App\Traits\Promotions;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class Products1c extends Component
{
    use WithPagination;
    use WireToast;
    use Promotions;

    public $search;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $itemsPerPage = 30;
    public $onlyPromotions = false;
    public $editProduct1c;
    public $promotions = [
        '1' => 'Уценка',
        //'2' => '1+1',
        '3' => 'Акция поставщика',
        '4' => 'Праздничные',
    ];
    public $promotion = [
        'type' => null,
        'stock' => null,
        'percent' => null,
        'date' => null,
    ];
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'sortField',
        'sortDirection',
        'itemsPerPage',
        'onlyPromotions',
    ];
    protected $listeners = ['save'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openForm($product1cId)
    {
        $this->editProduct1c = Product1C::where('id', $product1cId)
        ->first()
        ->toArray();

        $this->dispatchBrowserEvent('open-form');
    }

    public function save()
    {
        $this->validate([
            'promotion.type' => 'required',
        ]);

        if ($this->promotion['type'] === '2') {
            $this->validate([
                'promotion.stock' => 'required|numeric',
                'promotion.date' => 'required|date|date|date_format:Y-m-d|after:today',
            ]);
        } elseif ($this->promotion['type'] === '3' || $this->promotion['type'] === '1') {
            $this->validate([
                'promotion.percent' => 'required|numeric|between:1,100',
            ]);
        } elseif ($this->promotion['type'] === '4') {
            $this->validate([
                'promotion.percent' => 'required|numeric|between:1,100',
                'promotion.date' => 'required|date|date_format:Y-m-d|after:today',
            ]);
        }

        try {
            $this->initPromotion($this->editProduct1c, $this->promotion);

            toast()
                ->success('Акция создана')
                ->push();
        } catch (\Throwable$th) {
            \Log::error($th);

            toast()
                ->warning('В процессе создания акции произошла ошибка')
                ->push();
        }
        $this->cleanCache();
        $this->closeForm();
    }

    public function cleanCache()
    {
        Cache::forget('discountsCats-homepage');
        Cache::forget('discountsDogs-homepage');
        Cache::forget('discountsBirds-homepage');
        Cache::forget('discountsRodents-homepage');
    }

    public function stop()
    {
        $this->stopPromotion($this->editProduct1c['id']);
        $this->cleanCache();
        $this->closeForm();
        toast()
            ->success('Акция прекращена')
            ->push();
    }

    public function closeForm()
    {
        $this->reset('editProduct1c', 'promotion');
        $this->dispatchBrowserEvent('close');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sortDirection = 'desc';
        }
        $this->sortField = $field;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.dashboard.products1c', [
            'products1c' => Product1C::when($this->search, function ($query) {
                $query->whereLike(['name', 'id', 'barcode', 'cod1c'], $this->search);
            })
                ->when($this->onlyPromotions, function ($query) {
                    $query->where('promotion_type', '!=', 0);
                })
                ->with('product')
                ->with('product.unit')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->itemsPerPage),
        ])
            ->extends('dashboard.app')
            ->section('content');
    }
}
