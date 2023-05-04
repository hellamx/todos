<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Todo's</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    	<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ route('dashboard') }}/public/css/style.css">
	</head>
    <body>

        <main>
            <div class="container py-4">
                <header class="mb-4 border-bottom">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-dark text-decoration-none">
                        <span class="fs-1">Todo's</span>
                    </a>
                </header>
                @yield('content')
            </div>
        </main>
          
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="{{ route('dashboard') }}/public/js/typeahead.js"></script>
        <script src="{{ route('dashboard') }}/public/js/search.js"></script>
        <script src="{{ route('dashboard') }}/public/js/main.js"></script>
    </body>
</html>