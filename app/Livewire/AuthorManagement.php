<?php

namespace App\Livewire;

use App\Models\Author;
use Livewire\Component;
use Livewire\WithPagination;

class AuthorManagement extends Component
{
    use WithPagination;

    public $name = '';
    public $editingId = null;
    public $search = '';
    
    protected $rules = [
        'name' => 'required|min:2|max:255',
    ];

    public function __invoke()
    {
        return $this->render();
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $author = Author::find($this->editingId);
            $author->update(['name' => $this->name]);
            session()->flash('message', 'Autorius sėkmingai atnaujintas.');
        } else {
            Author::create(['name' => $this->name]);
            session()->flash('message', 'Autorius sėkmingai sukurtas.');
        }

        $this->reset(['name', 'editingId']);
    }

    public function edit($id)
    {
        $author = Author::find($id);
        $this->name = $author->name;
        $this->editingId = $id;
    }

    public function delete($id)
    {
        Author::find($id)->delete();
        session()->flash('message', 'Autorius sėkmingai ištrintas.');
    }

    public function cancel()
    {
        $this->reset(['name', 'editingId']);
    }

    public function render()
    {
        $authors = Author::where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.author-management', compact('authors'));
    }
}