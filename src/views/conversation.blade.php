<div class="box">

    @if(isset($conversation))

        <h3 class="">Deine Unterhaltung mit {{$conversation->getConversationPartner()->name}}</h3>

        <div class="">

            <input id="accodion-btn" class="checkbox-input" type="checkbox" name="tabs">
            <label for="accodion-btn" class="accordion-label">Neue Nachricht schreiben (remove or use for accordion)</label>

            <div class="dropdown-panel">
                <div class="dropdown-panel-content">
                    @php $user = $conversation->getConversationPartner();@endphp
                    @include('drhd.inbox.createForm', $user)
                </div>
            </div>
            @include("inbox::alert", ['field' => "private_message_text"])
            <hr class="horizontal-divider">

        </div>

        @foreach($privateMessages as $privateMessage)
            <div class="card mb-2 p-2">

                <div class="">
                    <strong class="">{{$privateMessage->user->name}}</strong>
                    <strong class="">{{$privateMessage->created_at->format('d.m.y H:i')}}</strong>
                </div>
                <div class="">
                    <strong class="">Betreff:</strong>
                    @if(isset($privateMessage->private_message_subject))
                        <span class="">{{$privateMessage->private_message_subject}}</span>
                    @else
                        <span class="">-</span>
                    @endif

                </div>
                <hr class="">
                <div class="">
                    {!! nl2br(e($privateMessage->private_message_text)) !!}
                </div>
            </div>
        @endforeach

        <div class="">
            {{ $privateMessages->links() }}
        </div>

    @else
        <span>Keine Unterhaltung ausgewählt.</span>
    @endif


</div>


