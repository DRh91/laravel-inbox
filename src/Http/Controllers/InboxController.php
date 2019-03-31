<?php

namespace drhd\inbox\Http\Controllers;

use App\Http\Controllers\Controller;
use drhd\inbox\Http\Requests\PrivateMessageRequest;
use drhd\inbox\Messenger\ErrorMessages;
use drhd\inbox\Messenger\MessengerException;
use drhd\inbox\Messenger\Messenger;
use Illuminate\Support\Facades\Auth;
use app\User;


class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view("drhd.inbox.index")->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("drhd.inbox.newMessage");
    }

    /**
     * @param PrivateMessageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PrivateMessageRequest $request)
    {
        try {
            $messenger = new Messenger();

            $text = $request->input('private_message_text');
            $subject = $request->input('private_message_subject');
            $user_sender = Auth::user();
            $user_receiver = User::where('name', '=', $request->input('receiver_name'))->first();

            if(is_null($user_receiver)) throw new MessengerException(ErrorMessages::RECEIVER_MISSING_OR_NOT_EXISTING);

            $messenger->sendPrivateMessage($user_sender, $user_receiver, $subject, $text);

            $conversationId = $messenger->getConversation($user_sender, $user_receiver)->id;

            if($request->input('redirect-to-inbox') === 'true'){
                return redirect("inbox/$conversationId")->with('message', 'Nachricht erfolgreich versendet.');
            }
            return redirect()->back()->with('message', 'Nachricht erfolgreich versendet.');
        }
        catch (MessengerException $exception){

            if($request->input('redirect-to-inbox') === 'true'){
                return redirect("inbox")->with('message', $exception->getMessage());
            }
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $messenger = new Messenger();

            $user = Auth::user();
            $conversation = $messenger->getConversationById($id);

            if(!($messenger->isParticipant($user, $conversation))) throw new MessengerException("User is no participant of this conversation.");

            $privateMessages = $conversation->privateMessages()->paginate(6);
            $conversation->markAsRead();

            return view("drhd.inbox.index")->with('user', $user)->with('conversation', $conversation)->with('privateMessages', $privateMessages);
        }
        catch (MessengerException $e) {
            return redirect('/inbox')->withErrors($e->getMessage());
        }

    }


}
