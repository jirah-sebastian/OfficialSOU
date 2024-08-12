<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLSU-SOU</title>

</head>

<body>
    <header>
        <img src="https://clsu.edu.ph/public/assets/img/general/logo-white.png" alt="logo">
        <h1>CLSU Student Organization Unit</h1>
        <p></p>
    </header>
    <main>

        <p>Dear {{ $applicant }},</p>

        <p>
            We regret to inform you that your membership application for {{ $so }} has been <b>REJECTED</b>.
        </p>

        <p>
            [Include any specific reasons or information regarding the decision.]
        </p>

        <p>
            If you have any questions or would like further clarification, feel free to reach out.
        </p>

        <p>
            Thank you for your understanding.
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
