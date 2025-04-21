<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $website->name }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    @if($website->sections->count() > 0)
        @foreach($website->sections as $websiteSection)
            <div id="section-{{ $websiteSection->id }}" class="website-section">
                {!! $websiteSection->section->html_template !!}
            </div>
        @endforeach
    @else
        <div class="container py-5 text-center">
            <h1>{{ $website->name }}</h1>
            <p>This website doesn't have any content yet.</p>
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html> 