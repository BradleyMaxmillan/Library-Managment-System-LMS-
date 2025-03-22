<!DOCTYPE html>
<html lang="en">
<head>
    <title>Footer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Ensure full-page height */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Push footer to bottom */
        .content {
            flex: 1;
        }

        /* Footer styling */
        footer {
            width: 100%;
            background: rgba(0, 0, 0, 0.95); /* Darker for better contrast */
            color: #f8f9fa;
            text-align: center;
            padding: 40px 0; /* Increased padding for full coverage */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 -4px 10px rgba(255, 255, 255, 0.1);
            min-height: 200px; /* Ensure full background */
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .fa {
            padding: 15px;
            font-size: 24px;
            width: 50px;
            height: 50px;
            text-align: center;
            text-decoration: none;
            border-radius: 50%;
            transition: all 0.3s ease-in-out;
        }

        .fa:hover {
            transform: scale(1.1);
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.3);
        }

        .fa-facebook { background: #3B5998; color: white; }
        .fa-twitter { background: #55ACEE; color: white; }
        .fa-google { background: #dd4b39; color: white; }
        .fa-instagram { background: #C13584; color: white; }
        .fa-yahoo { background: #400297; color: white; }

        .contact-info {
            font-size: 16px;
            margin-top: 20px;
            opacity: 0.9;
            width: 100%;
            text-align: center;
        }

        .contact-info a {
            color: #f8f9fa;
            text-decoration: none;
            font-weight: bold;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="content">
    <!-- Your page content goes here -->
</div>

<footer>
    <h3 class="mb-3">Contact Us Through Social Media</h3>

    <div class="social-icons">
        <a href="#" class="fa fa-facebook"></a>
        <a href="#" class="fa fa-twitter"></a>
        <a href="#" class="fa fa-google"></a>
        <a href="#" class="fa fa-instagram"></a>
        <a href="#" class="fa fa-yahoo"></a>
    </div>

    <p class="contact-info">
        Email: <a href="mailto:Online.library@gmail.com">Online.library@gmail.com</a> <br>
        Mobile: +2547********
    </p>
</footer>

</body>
</html>
