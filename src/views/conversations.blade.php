<div class="box">

    <h3 class="title is-5">Deine Unterhaltungen</h3>

    @if(sizeof($user->conversations) == 0)
        <span>Noch keine Unterhaltungen vorhanden.</span>
    @endif

    @foreach($user->conversations as $conversation)

        <a href="/inbox/{{$conversation->id}}">
            <div class="card conversation-info-box">
                <div class="card-content">

                    {{-- communication partner and unread messages --}}

                    <div class="conversation-info-box-header">
                        @if($conversation->getNumberOfUnreadMessages() > 0)
                            <strong class="is-size-5">{{$conversation->getConversationPartner()->name}}</strong>
                        @else
                            <span class="is-size-5">{{$conversation->getConversationPartner()->name}}</span>
                        @endif

                        {{--number of unread mesages--}}
                        <div class="">
                            @if($conversation->getNumberOfUnreadMessages($user) > 0)
                                <i class="far fa-envelope"></i>
                                <strong> {{$conversation->getNumberOfUnreadMessages($user)}}</strong>
                            @else
                                <i class="far fa-envelope-open"></i>
                            @endif
                        </div>


                    </div>

                    <small class="last-message-date">Letzte
                        Nachricht: {{$conversation->getLastMessage()->created_at->format('d.m.y H:i')}}
                        von {{$conversation->getLastMessage()->user->name}}</small>
                </div>
            </div>
        </a>

    @endforeach

    <hr class="">

    <div id="button-new-message-container" class="has-text-centered">
        <a href="/inbox/create" class="button has-background-primary has-text-white is-fullwidth">Nachricht schreiben</a>
    </div>


</div>
