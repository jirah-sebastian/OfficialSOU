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
            We are pleased to inform you that the membership application submitted by <b>{{ $applicant_name }}</b> to
            <b>{{ $so_name }}</b> has been <b>APPROVED</b> by the CLSU Student Organization Unit.

        </p>
        <p>
            Your support is appreciated as we continue to strengthen our organization. Should you have any questions or
            require assistance, please do not hesitate to contact us.

        </p>
        <p>
            Thank you for your cooperation.
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
