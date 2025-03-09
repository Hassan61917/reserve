<?php

namespace App\Http\Controllers\Api\v1\Common;

use App\Http\Controllers\AuthBaseController;
use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\Common\CommonTicketRequest;
use App\Http\Resources\v1\TicketMessageResource;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use App\ModelServices\Support\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommonTicketController extends AuthUserController
{
    protected string $resource = TicketResource::class;

    public function __construct(
        public TicketService $ticketService
    )
    {
    }

    public function index(): JsonResponse
    {
        $tickets = $this->ticketService->getTicketsFor($this->authUser(), ["category"]);
        return $this->ok($this->paginate($tickets));
    }

    public function store(CommonTicketRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authUser();
        $ticket = $this->ticketService->make($user, $data);
        $this->ticketService->addMessage($ticket, $data["body"]);
        return $this->ok($ticket);
    }

    public function addMessage(Request $request, Ticket $ticket): JsonResponse
    {
        $data = $request->validate([
            "body" => "required|string",
        ]);
        $message = $this->ticketService->addMessage($ticket, $data["body"]);
        return $this->ok($message, TicketMessageResource::make($message));
    }

    public function close(Request $request, Ticket $ticket): JsonResponse
    {
        $data = $request->validate([
            "rate" => "nullable|numeric|between:1,5",
        ]);
        $this->ticketService->close($ticket, $data["rate"]);
        return $this->ok($ticket);
    }

    public function show(Ticket $ticket): JsonResponse
    {
        $ticket->load("category", "messages");
        $this->ticketService->seenMessage($this->authUser(), $ticket);
        return $this->ok($ticket);
    }

    public function update(CommonTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $data = $request->dontUnset()->validated();
        $ticket->update($data);
        return $this->ok($ticket);
    }

    public function destroy(Ticket $ticket): JsonResponse
    {
        $ticket->delete();
        return $this->deleted();
    }
}
