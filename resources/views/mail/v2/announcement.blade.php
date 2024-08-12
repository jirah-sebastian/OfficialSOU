<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLSU-SOU</title>
</head>

<body>
    <main>
        <p>
            Dear {{ $pres }},
        </p>
        <p>
            There's a new announcement that we would like to bring to your attention. Please find the details below.
        </p>
        <p>
            Announcement Details:
        </p>
        <p>
            <b>Title:</b> {{ $title }}
        </p>
        <p>
            <b>Information:</b> {!! $content !!}
        </p>
        <p>
            Thank you for your attention.
        </p>
        <p>
            Best regards,<br>
            CLSU Student Organization Unit
        </p>

    </main> 
</body>
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 20px;
    }

    header {
        text-align: center;
        padding: 10px;
        background-color: green;
        /* For browsers that do not support gradients */
        /* background-image: radial-gradient(#e5ff00, green); */
    }

    header img {
        max-width: 100px;
        /* Adjust the maximum width of the logo */
    }

    main {
        padding: 20px;
    }

    footer {
        text-align: center;
        padding: 10px;
        background-color: #f2f2f2;
    }
</style>
</html>
