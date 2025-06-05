<?php

namespace App\Livewire;

use App\Models\Recipe;
use App\Models\Author;
use Livewire\Component;
use Livewire\WithPagination;

class RecipeManagement extends Component
{
    use WithPagination;

    public $title = '';
    public $description = '';
    public $author_id = '';
    public $editingId = null;
    public $search = '';

    protected $rules = [
        'title' => 'required|min:2|max:255',
        'description' => 'nullable|string',
        'author_id' => 'required|exists:authors,id',
    ];

    public function __invoke()
    {
        return $this->render();
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $recipe = Recipe::find($this->editingId);
            $recipe->update([
                'title' => $this->title,
                'description' => $this->description,
                'author_id' => $this->author_id,
            ]);
            session()->flash('message', 'Receptas sėkmingai atnaujintas.');
        } else {
            Recipe::create([
                'title' => $this->title,
                'description' => $this->description,
                'author_id' => $this->author_id,
            ]);
            session()->flash('message', 'Receptas sėkmingai sukurtas.');
        }

        $this->reset(['title', 'description', 'author_id', 'editingId']);
    }

    public function edit($id)
    {
        $recipe = Recipe::find($id);
        $this->title = $recipe->title;
        $this->description = $recipe->description;
        $this->author_id = $recipe->author_id;
        $this->editingId = $id;
    }

    public function delete($id)
    {
        Recipe::find($id)->delete();
        session()->flash('message', 'Receptas sėkmingai ištrintas.');
    }

    public function cancel()
    {
        $this->reset(['title', 'description', 'author_id', 'editingId']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $recipes = Recipe::with('author')
            ->where('title', 'like', '%' . $this->search . '%')
            ->paginate(10);
            
        $authors = Author::all();

        return view('livewire.recipe-management', compact('recipes', 'authors'));
    }
}