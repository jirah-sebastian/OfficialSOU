<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLSU-SOU</title>

</head>

<body>
    <main>

        <P>
            Dear {{ $so_pres }},
        </P>
        <p>
            We are pleased to inform you that your application for an account for {{ $so_name }} has been APPROVED.

        </p>
        <p>
            Congratulations! We look forward to providing you access to our platform.

        </p>
        <p>
            Here are the account details:

        </p>
        <p>
            <b>Organization Name:</b> {{ $so_name }} <br>

            <b>Contact Person:</b> {{ $so_pres }} <br>

            <b>Contact Email:</b> {{ $email }}
        </p>

        <p>
            Please review this information, and if you have any questions or need assistance, feel free to reach out to
            us. We're here to support you.

        </p>
        <p>
            Thank you for choosing to utilize our services.
        </p>
        <p>
            Best regards, <br>

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
