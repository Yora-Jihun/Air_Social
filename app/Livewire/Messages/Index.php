<?php

namespace App\Livewire\Messages;

use Livewire\Component;

class Index extends Component
{
    public ?int $activeConversation = 1;

    public string $newMessage = '';

    public string $search = '';

    public array $conversations = [];

    public array $threads = [];

    public function mount(): void
    {
        $this->conversations = [
            ['id' => 1, 'name' => 'Maria Cristina Reyes', 'role' => 'Relationship Manager · BDO', 'avatar' => null, 'last' => 'Sounds good, see you at 3!', 'time' => '10:32', 'unread' => 2, 'online' => true],
            ['id' => 2, 'name' => 'Juan Miguel Santos', 'role' => 'Software Engineer · BDO', 'avatar' => null, 'last' => 'Pushed the fix to staging.', 'time' => '9:15', 'unread' => 0, 'online' => false],
            ['id' => 3, 'name' => 'Ana Marie Cruz', 'role' => 'Branch Operations · BDO', 'avatar' => null, 'last' => 'Thanks for the update!', 'time' => 'Yesterday', 'unread' => 0, 'online' => true],
            ['id' => 4, 'name' => 'Paolo Mendoza', 'role' => 'Data Analyst · BDO', 'avatar' => null, 'last' => 'Hi There Jerome! Numbers look great this quarter.', 'time' => '8:21 PM', 'unread' => 0, 'online' => true],
        ];

        $this->threads = [
            1 => [
                ['from' => 'them', 'name' => 'Maria Cristina Reyes', 'text' => 'Are we still on for the 3pm sync?', 'time' => '10:20'],
                ['from' => 'me', 'text' => 'Yes! Joining in 5.', 'time' => '10:25'],
                ['from' => 'them', 'name' => 'Maria Cristina Reyes', 'text' => 'Sounds good, see you at 3!', 'time' => '10:32'],
            ],
            2 => [
                ['from' => 'them', 'name' => 'Juan Miguel Santos', 'text' => 'Pushed the fix to staging, please smoke test.', 'time' => '9:10'],
                ['from' => 'me', 'text' => 'On it now.', 'time' => '9:12'],
                ['from' => 'them', 'name' => 'Juan Miguel Santos', 'text' => 'Pushed the fix to staging.', 'time' => '9:15'],
            ],
            3 => [
                ['from' => 'them', 'name' => 'Ana Marie Cruz', 'text' => 'Branch roster for next week is ready.', 'time' => 'Yesterday'],
                ['from' => 'me', 'text' => 'Thanks for the update!', 'time' => 'Yesterday'],
            ],
            4 => [
                ['from' => 'them', 'name' => 'Paolo Mendoza', 'text' => 'Hi There Jerome! Numbers look great this quarter.', 'time' => '8:23 PM'],
            ],
        ];
    }

    public function selectConversation(int $id): void
    {
        $this->activeConversation = $id;
        $this->newMessage = '';
    }

    public function backToList(): void
    {
        $this->activeConversation = null;
    }

    public function sendMessage(): void
    {
        $text = trim($this->newMessage);
        if ($text === '' || $this->activeConversation === null) {
            return;
        }

        $this->threads[$this->activeConversation][] = [
            'from' => 'me',
            'text' => $text,
            'time' => 'now',
        ];

        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.messages.index')->layout('layouts.newsfeed');
    }
}
