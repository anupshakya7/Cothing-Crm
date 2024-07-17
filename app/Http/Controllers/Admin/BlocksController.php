<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Block;
use App\Models\Page;
use App\Http\Controllers\Controller;

class BlocksController extends Controller
{
    protected $blocks;
    protected $pages;

    function __construct(Block $blocks, Page $pages)
    {
        $this->blocks = $blocks;
        $this->pages = $pages;
        Parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blocks = $this->blocks->orderBy('created_at', 'desc')->paginate(10);
        return view('backend.blocks.index', compact('blocks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Block $block)
    {
        $positions = ['block'=>'Block', 'header'=>'Header', 'slider'=>'Slider'];

        $display = ['allPage'=>'All Pages', 'home'=>'Only Home', 'noHome'=>'All But Home'];

        $columns = ['col-md-12'=>'One', 'col-md-6'=>'Two', 'col-md-4'=>'Three'];

        $filters = ['recent'=>'Recent', 'random'=>'Random', 'category'=>'Category'];

        $categories = $this->pages->where('hidden', false)->where('type', 'category')->orderBy('lft', 'asc')->get();

        return view('backend.blocks.form', compact('block', 'positions', 'display', 'columns', 'filters', 'categories'));
    }


    public function store(Request $request)
    {
        $block = $this->blocks->create($request->only('title', 'position', 'display', 'show_title', 'published', 'order', 'column', 'filter', 'limit', 'category_id', 'style'));

        return redirect(route('blocks.index'))->with('status', 'Block has been created!');
    }



      public function edit($id)
    {
        $block = $this->blocks->findOrFail($id);

        $positions = ['block'=>'Block', 'header'=>'Header', 'slider'=>'Slider'];

        $display = ['allPage'=>'All Pages', 'home'=>'Only Home', 'noHome'=>'All But Home'];

        $columns = [''=>'', 'col-md-12'=>'One', 'col-md-6'=>'Two', 'col-md-4'=>'Three'];

        $filters = [''=>'', 'recent'=>'Recent', 'random'=>'Random', 'category'=>'Category'];

        $categories = $this->pages->where('hidden', false)->where('type', 'category')->orderBy('lft', 'asc')->get();

        return view('backend.blocks.form', compact('block', 'positions', 'display', 'columns', 'filters', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $block = $this->blocks->findOrFail($id);

        $block->fill($request->only('title', 'position', 'display', 'show_title', 'published', 'order', 'column', 'filter', 'limit', 'category_id', 'style'))->save();

        return redirect(route('blocks.edit', $block->id))->with('status', 'Block has been created');
    }

    public function confirm($id)
    {
        $block = $this->blocks->findOrFail($id);
        return view('backend.blocks.confirm', compact('block'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $block = $this->blocks->findOrFail($id);

        $block->delete();

        return redirect(route('blocks.index'))->with('status', 'Block has been deleted!');
    }
}
