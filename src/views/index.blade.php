@extends('layouts.app')

@section('content')

    <section class="section is-first-box">

        @include("inbox::messageNotificationHandling")

        <div class="row">

            <div class="col-sm-3">
                @include("drhd.inbox.conversations")
            </div>

            <div class="col-sm-9">
                @include("drhd.inbox.conversation")
            </div>
        </div>

    </section>

@endsection
