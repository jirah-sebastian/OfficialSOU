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
            Dear {{ $applicant_name }},
        </p>
        <p>
            Thank you for your interest in becoming a member of <b>{{ $so_name }}</b>. We have received your
            membership
            application and will review it accordingly.

        </p>
        <p>
            <b>Applicant Details:</b>
        </p>
        <p>
            <b>Name:</b> {{ $applicant_name }} <br>
            <b>Email:</b> {{ $applicant_email }} <br>
            <b>Membership Type:</b> {{ $applicant_position }} <br>
            <b>Date Submitted:</b> {{ $created_at }} <br>
        </p>
        <p>
            We will notify you once a decision has been made on your application. If you have any questions in the
            meantime, feel free to reach out to us.
        </p>
        <p>
            Best regards, <br>
            {{ $so_pres }} <br>
            President of
            {{ $so_name }}
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
