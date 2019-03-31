@extends('layouts.default')
@section('content')


<section class="section is-first-box">
    <div class="box">

        <h1 class="title is-3">Neue Nachricht schreiben</h1>

        @include("inbox::createForm")
</section>


@endsection
