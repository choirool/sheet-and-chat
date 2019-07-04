@extends('layouts.app')

@section('content')
    <div id="app">
        <h2>{{ $sheet->name }}</h2>
        <sheet></sheet>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/handsontable/2.0.0/handsontable.min.css">
@endpush

@push('scripts')
    <script>
        var sheetData = @json($sheet->content),
            sheetChannel = '{{ $sheet->channel_name }}',
            fetchUrl = '/sheets/{{ $sheet->id }}';
    </script>
@endpush

