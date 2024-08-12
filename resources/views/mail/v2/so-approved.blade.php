<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLSU-SOU</title>
</head>

<body>
    <main>

        <p>Dear {{ $applicant }},</p>

        <p>
            I hope this message finds you well. We are pleased to inform you that your membership application for
            {{ $so }} has been reviewed and approved.
        </p>

        <p>
            Welcome to our community! We look forward to your active participation and contributions to our
            organization. If you have any questions or need further information, please feel free to reach out.
        </p>

        <p>
            Thank you for choosing to be a part of {{ $so }}.
        </p>

        <p>
            Best regards,
            <br>
            {{ $pres }}
            <br>
            {{ $position }}
            <br>
            {{ $so }}
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
        background-color: #f2f2f2;
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
