<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostType;
use Livewire\Component;
use Livewire\WithPagination;

class BackendPostList extends Component
{
    use WithPagination;

    public $search = [
        'title' => '',
        'type' => '',
        'published' => '',
    ];

    public $status = [
        'published' => 'Published',
        'draft' => 'Draft',
    ];

    public $orderBy = 'created_at';

    public $sort = 'desc';

    public $per_page = 25;

    public function render()
    {

        return view('livewire.backend-post-list',
            [
                'posts' => $this->getPosts(),
                'post_types' => PostType::all(),
            ]
        );
    }

    public function getPosts()
    {
        return Post::whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->when($this->search['title'], function ($query) {
                return $query->where('title', 'like', '%'.$this->search['title'].'%');
            })
            ->when($this->search['type'], function ($query) {
                return $query->where('post_type_id', $this->search['type']);
            })
            ->when($this->search['published'], function ($query) {
                return $query->where('meta->published', $this->search['published']);
            })
            ->orderBy($this->orderBy, $this->sort)
            ->paginate($this->per_page);
    }

    public function sortBy($field)
    {
        if ($this->orderBy == $field) {
            $this->sort = $this->sort == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = 'asc';
        }

        $this->orderBy = $field;
    }
}
