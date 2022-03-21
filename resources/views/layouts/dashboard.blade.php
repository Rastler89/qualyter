<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>{{ config('app.name', 'Laravel') }}</title>

	<link rel="stylesheet" href="https://unpkg.com/@adminkit/core@latest/dist/css/app.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset("css/custom.css") }}">
	@yield('styles')
</head>

<body>
	<div class="wrapper">
        @include('partials.navbar')
		

		<div class="main">
			@include('partials.sectionHeader')
			<main class="content">
				<div class="container-fluid p-0">
					@include('partials.alerts')
					@yield('content')
				</div>
			</main>
            @include('partials.footer')
		</div>
	</div>

	<script src="https://unpkg.com/@adminkit/core@latest/dist/js/app.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script type="module">
		// Import the functions you need from the SDKs you need
		import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.9/firebase-app.js";
		import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.9/firebase-analytics.js";
		// TODO: Add SDKs for Firebase products that you want to use
		// https://firebase.google.com/docs/web/setup#available-libraries
	  
		// Your web app's Firebase configuration
		// For Firebase JS SDK v7.20.0 and later, measurementId is optional
		const firebaseConfig = {
		  apiKey: "AIzaSyDca6SrYPstzJ3bwwI9ypz4Cj8_gqxo3Qs",
		  authDomain: "optimaqc-ff9bd.firebaseapp.com",
		  projectId: "optimaqc-ff9bd",
		  storageBucket: "optimaqc-ff9bd.appspot.com",
		  messagingSenderId: "838780631674",
		  appId: "1:838780631674:web:8523c1b7a317942b1c99c3",
		  measurementId: "G-G5F8BSKSB3"
		};
	  
		// Initialize Firebase
		const app = initializeApp(firebaseConfig);
		const analytics = getAnalytics(app);
	  </script>
    @yield('javascript')
</body>

</html>