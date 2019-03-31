<?php

namespace drhd\inbox\Messenger;

use App\User;
use drhd\inbox\models\Conversation;

class Messenger {

    private $messenger_helper;

    /**
     * Messenger constructor.
     */
    public function __construct() {
        $this->messenger_helper = new MessengerHelper();
    }

    /**
     * Sends a private message from one user to another.
     *
     * @param User $from sender of the private message
     * @param User $to receiver of the private message
     * @param $message_subject subject of the private message - can be null or empty
     * @param $message_text body/text/content of this message
     * @throws MessengerException thrown if sender, receiver or message text is null or empty
     */
    public function sendPrivateMessage(User $from, User $to, $message_subject, $message_text) {

        $this->validateInput($from, $to, $message_text);

        $this->messengerHelper()->createConversationIfNecessary($from, $to);

        $conversation = $this->getConversation($from, $to);

        $privateMessage = $this->messengerHelper()->createPrivateMessageObject($from, $message_text, $message_subject, $conversation);

        $privateMessage->save();

        $conversation->updated_at = now();

        $conversation->save();
    }


    /**
     * Returns the conversation object matching the passed users. Throws a MessengerException if there is no
     * conversation between the passed users.
     *
     * @param $user_sender
     * @param $user_receiver
     * @return Conversation
     * @throws MessengerException
     */
    public function getConversation($user_sender, $user_receiver) : Conversation{

        if ($this->messengerHelper()->conversationExists($user_sender, $user_receiver)) {
            $conversations_from_sender = $user_sender->conversations;
            $conversations_from_receiver = $user_receiver->conversations;

            foreach ($conversations_from_sender as $conversation_sender) {

                foreach ($conversations_from_receiver as $conversation_receiver) {
                    if ($conversation_sender->id === $conversation_receiver->id) return $conversation_sender;
                }
            }
        } else {
            throw new MessengerException("there is no conversation between " . $user_sender->name . " and " . $user_receiver->name);
        }
    }

    /**
     * Returns the conversation object matching the passed id. Throws a MessengerException if there is no
     * conversation with this id as primary key.
     *
     * @param $id id of the conversation
     * @return Conversation the conversation matching the id
     * @throws MessengerException is thrown if there is no conversation associated with this id
     */
    public function getConversationById($id) : Conversation{
        if($this->messengerHelper()->conversationIdExists($id))
            return Conversation::find($id);
    }


    /**
     * Checks if the passed user is participant of the passed conversation.
     * @param $user User to be checked for being participant of the passed conversation.
     * @param $conversation
     * @return bool
     */
    public function isParticipant($user, $conversation) {

        $participants = $conversation->users;

        foreach ($participants as $participant) {
            if ($participant->id === $user->id) return true;
        }
        return false;
    }


    /**
     * Checks if receiver, sender or message text is null or empty and if sender equals receiver. If that is the case a MessengerException is thrown.
     * @param User $from
     * @param User $to
     * @param $message_text
     * @throws MessengerException
     */
    private function validateInput(User $from, User $to, $message_text): void {

        $error_message_prefix = config('inboxErrorMessages')['error_message_prefix'];

        if ($from == null) throw new MessengerException($error_message_prefix.config('inboxErrorMessages')['sender_missing']);
        if ($to == null) throw new MessengerException($error_message_prefix.config('inboxErrorMessages')['receiver_missing_or_not_existing']);
        if ($message_text === null) throw new MessengerException($error_message_prefix.config('inboxErrorMessages')['message_text_missing']);
        if ($from->email === $to->email) throw new MessengerException($error_message_prefix.config('inboxErrorMessages')['sender_equals_receiver']);
    }


    /** Helper method to return the messenger_helper object to enable auto-completion in php storm */
    private function messengerHelper(): MessengerHelper {
        return $this->messenger_helper;
    }

}