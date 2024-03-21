<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Video;
use Livewire\WithPagination;

class VideoScreen extends Component
{
    use WithPagination;

    #[Layout('components.layouts.web')]
    #[Title('Video')]

    public function render()
    {
        return view('livewire.web.video', [
            'videos' => Video::where('active', 1)->latest('created_at')->paginate(12)
        ]);
    }

    public function paginationView()
    {
        return 'components.shared.pagination';
    }
}
