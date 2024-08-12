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
            We hope this email finds you well. Thank you for your interest in establishing {{ $so_name }} at our
            institution. After a thorough review of your application, we regret to inform you that your application has
            been <b>REJECTED<b>.
        </p>
        <p>
            <b>Reason/s for Rejection:</b>
        </p>
        <p>
            {{ $remarks }}
        </p>
        <p>
            We understand that this may be disappointing, and we appreciate the time and effort you invested in the
            application process. Please note that this decision does not diminish the value of your ideas and
            initiatives.
        </p>
        <p>
            Thank you for your understanding, and we wish you the best in your future endeavors.
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
