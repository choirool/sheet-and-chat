<head>
    <title>{{ $sheet->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/handsontable/2.0.0/handsontable.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<br>
<div id="app">
    <h2>{{ $sheet->name }}</h2>
    <div id="sheet"></div>
    <sheet></sheet>
</div>
<script>
    var sheetData = @json($sheet->content),
        sheetChannel = '{{ $sheet->channel_name }}',
        fetchUrl = '/sheets/{{ $sheet->id }}';
</script>
<script src="{{ mix('js/app.js') }}"></script>
