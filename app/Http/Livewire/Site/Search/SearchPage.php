<?php

namespace App\Http\Livewire\Site\Search;

use App\Traits\Searcheable;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;
use Livewire\WithPagination;

class SearchPage extends Component
{
    use WithPagination;

    use Searcheable;

    public String $q = 'корм';
    public String $metaTitle = 'ZooPodarki';
    public String $metaDescription = 'ZooPodarki';
    public String $name = 'ZooPodarki';
    public String $sortSelectedName = 'По популярности';
    public String $sortSelectedType = 'popularity';
    public String $sortBy = 'desc';
    public $sortType = [
        '0' => [
            'name' => 'По популярности',
            'type' => 'popularity',
            'sort' => 'asc',
        ],
        '1' => [
            'name' => 'Название: от А до Я',
            'type' => 'name',
            'sort' => 'asc',
        ],
        '2' => [
            'name' => 'Название: от Я до А',
            'type' => 'name',
            'sort' => 'desc',
        ],
        '3' => [
            'name' => 'Цена по возрастанию',
            'type' => 'price_avg',
            'sort' => 'asc',
        ],
        '4' => [
            'name' => 'Цена по убыванию',
            'type' => 'price_avg',
            'sort' => 'desc',
        ],
    ];

    public function mount()
    {
        if (request()->has('q')) {
            $this->q = request()->q;
        }

        $this->seo();
    }

    public function seo()
    {
        SEOMeta::setTitle($this->metaTitle);
        SEOMeta::setDescription($this->metaDescription);
        OpenGraph::setTitle($this->metaTitle);
        OpenGraph::setDescription($this->metaDescription);
        OpenGraph::addProperty('type', 'website');
    }

    public function sortIt($type, $sort, $name)
    {
        $this->sortSelectedType = $type;
        $this->sortSelectedName = $name;
        $this->sortBy = $sort;
        $this->resetPage();
    }

    public function render()
    {
        $resultArray = $this->searchThis($this->q, false, $this->sortSelectedType, $this->sortBy);
        $this->q = $resultArray['search'];

        $this->emit('lozad', '');

        return view('livewire.site.search.search-page', [
            'products' => $resultArray['result'],
        ])
        ->extends('layouts.app')
        ->section('content');
    }
}
