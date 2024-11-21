<?php

namespace App\Livewire;

use App\Models\KanbanCard;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.staff')] 
class KanbanBoard extends Component
{
    protected $cards;
    public $statuses = ['todo', 'in_progress', 'review', 'done'];
    public $newCard = [
        'title' => '',
        'description' => '',
        'status' => 'todo',
        'assigned_to' => null,
        'due_date' => null
    ];

    public function mount()
    {
        $this->loadCards();
    }

    public function loadCards()
    {
        $this->cards = KanbanCard::with('user')
            ->orderBy('order')
            ->get()
            ->groupBy('status');
    }

    public function createCard()
    {
        $this->validate([
            'newCard.title' => 'required',
            'newCard.status' => 'required|in:todo,in_progress,review,done'
        ]);

        $maxOrder = KanbanCard::where('status', $this->newCard['status'])->max('order') ?? 0;

        KanbanCard::create([
            'title' => $this->newCard['title'],
            'description' => $this->newCard['description'],
            'status' => $this->newCard['status'],
            'assigned_to' => $this->newCard['assigned_to'],
            'due_date' => $this->newCard['due_date'],
            'order' => $maxOrder + 1
        ]);

        $this->reset('newCard');
        $this->loadCards();
    }

    public function updateCardPosition($cardId, $newStatus, $order)
{
    $card = KanbanCard::find($cardId);
    $card->update([
        'status' => $newStatus,
        'order' => $order
    ]);
    
    $this->dispatch('cardMoved');
    $this->loadCards();
}

    public function render()
    {
        return view('livewire.kanban-board', [
            'cards' => $this->cards
        ]);
    }
}
