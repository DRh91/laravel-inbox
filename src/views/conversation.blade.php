<div class="box">

    @if(isset($conversation))

        <h3 class="title is-5">Deine Unterhaltung mit {{$conversation->getConversationPartner()->name}}</h3>

        <div class="accordion">

            <input id="accodion-btn" class="checkbox-input" type="checkbox" name="tabs">
            <label for="accodion-btn" class="accordion-label">Neue Nachricht schreiben</label>

            <div class="dropdown-panel">
                <div class="dropdown-panel-content">
                    @php $user = $conversation->getConversationPartner();@endphp
                    @include('inbox::createForm', $user)
                </div>
            </div>
            @include("inbox::alert", ['field' => "private_message_text"])
            <hr class="horizontal-divider">

        </div>

        @foreach($privateMessages as $privateMessage)
            <div class="message-container">

                <div class="private-message-header">
                    <strong class="message-sender is-size-5">{{$privateMessage->user->name}}</strong>
                    <strong class="message-date">{{$privateMessage->created_at->format('d.m.y H:i')}}</strong>
                </div>
                <div class="message-subject">
                    <strong class="is-size-7">Betreff:</strong>
                    @if(isset($privateMessage->private_message_subject))
                        <span class="is-size-7">{{$privateMessage->private_message_subject}}</span>
                    @else
                        <span class="is-size-7">-</span>
                    @endif

                </div>
                <hr class="horizontal-divider">
                <div class="message-text is-size5">
                    {!! nl2br(e($privateMessage->private_message_text)) !!}
                </div>
            </div>
        @endforeach

        <div class="paginationLinks">
            {{ $privateMessages->links() }}
        </div>

    @else
        <span>Keine Unterhaltung ausgewählt.</span>
    @endif


</div>


