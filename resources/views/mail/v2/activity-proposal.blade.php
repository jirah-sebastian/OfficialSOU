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
            Dear CLSU Student Organization Unit,
        </p>
        <p>
            We would like to inform you that <b>{{ $so_name }} </b>from {{ $so_category }}</b> cluster has
            submitted an
            Activity Proposal.
        </p>

        <p>
            <b>ACTIVITY DETAILS:</b>
        </p>
        <p>
            <b>Activity Title:</b> {{ $activity_title }}
        </p>
        <p>
            <b>Control Number:</b> {{ $sub_title }}
        </p>
        <p>
            <b>Date of Implementation:</b> {{ \Carbon\Carbon::parse($event_date)->toFormattedDateString() }}
        </p>
        <p>
            <b>Venue:</b> {{ $event_place }}
        </p>
        <p>
            <b>Type of Activity:</b> {{ $type_of_activity }}
        </p>
        <p>
            <b>Sustainable Development Goal:</b> {{ implode(', ', $sustainable_development_goal) }}

        </p>
        <p>
            <b>Funding Source:</b> {{ $gad_funded }}
        </p>
        <p>
            <b>Description:</b> {!! $content !!}
        </p>

        <p>
            To review, please proceed to the portal. Thank you.
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
        /* background-color: #f2f2f2; */
        /* background: url('/assets/img/sou/logo-green.png'); */
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
