<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TOPHP Framework</title>
    <meta name="description" content="Prism is a beautiful Bootstrap 4 template for open-source landing pages."/>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=K2D:300,400,500,700,800" rel="stylesheet">

    <!-- Bootstrap CSS / Color Scheme -->
    <link rel="stylesheet" href="https://webresourcesdepot.com/demo/prism/css/bootstrap.css">
</head>
<body>

<style>
    .bg-gradient {
        background: linear-gradient(#f1f1f1, #f1f1e9);
    }
</style>
<!--Header Section-->
<section class="bg-gradient pt-5 pb-6">
    <div class="container">
        <?= $content ?>
    </div>
</section>
<!--footer-->
<footer class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="https://github.com/sobirjonovs">Test Drive</a></li>
                    <li class="list-inline-item"><a href="https://github.com/sobirjonovs">API Docs</a></li>
                    <li class="list-inline-item"><a href="https://github.com/sobirjonovs">Fork TOPHP on GitHub</a></li>
                </ul>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md-4 mx-auto text-muted text-center small-xl">
                &copy; 2021 tutorials.uz - All Rights Reserved
            </div>
        </div>
    </div>
</footer>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.7.3/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.15.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.15.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
</body>
</html>