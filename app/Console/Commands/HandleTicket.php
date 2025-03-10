<?php

namespace App\Console\Commands;

use App\ModelServices\Support\TicketService;
use Illuminate\Console\Command;

class HandleTicket extends Command
{
    public function __construct(
        private readonly TicketService $ticketService
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'close tickets automatically';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->closeTickets();
        $this->autoCloseTickets();
    }

    private function closeTickets(): void
    {
        $tickets = $this->ticketService->getClosedTickets();
        foreach ($tickets as $ticket) {
            if (now()->gte($ticket->close_at)) {
                $this->ticketService->close($ticket);
            }
        }
    }

    private function autoCloseTickets(): void
    {
        $tickets = $this->ticketService->getUnClosedTickets(["messages"]);
        foreach ($tickets as $ticket) {
            $lastMessage = $ticket->messages()->latest()->first();
            if ($lastMessage->seen_at) {
                $this->ticketService->autoClose($ticket);
            }
        }
    }
}
