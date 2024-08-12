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
            A new membership application has been submitted to <b>{{ $so_name }}</b>. Please review the details
            below and proceed to the portal for further action.
        </p>
        <p>
            Applicant Details:
        </p>
        <p>
            <b>Name:</b> {{ $applicant_name }} <br>
            <b>Email:<b> {{ $applicant_email }} <br>
            <b> Membership Type:<b> {{ $applicant_position }} <br>
            <b>Date Submitted:<b> {{ $created_at }} <br>
        </p>
        <p>
            Thank you for your attention to this matter.
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
