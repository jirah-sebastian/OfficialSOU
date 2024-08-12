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
            Dear {{ $so_pres }},
        </p>
        <p>
            We hope this message finds you well. We are thrilled to inform you about a new activity from
            <b>{{ $so_name }} </b> recently added. Please review the details below:

        </p>

        <p>
            <b>Details:</b>
        </p>
        <p>
            <b>Title:</b> {{ $activity->title }} <br>
            <b>Date of Implementation:</b> {{ $activity->event_date }}<br>
            <b>Venue:</b> {{ $activity->event_place }}<br>
            <b>Overview:</b> {!! $activity->content !!}
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
