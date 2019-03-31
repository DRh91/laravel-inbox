@extends('layouts.app')

@section('content')

<section class="section is-first-box">
    <div class="box">

        <h1 class="title is-3">Neue Nachricht schreiben</h1>

        @include("drhd.inbox.createForm")
</section>


@endsection
