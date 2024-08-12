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
            We are delighted to inform you that your membership application for <b>{{ $so_name }}</b> has been <b>APPROVED</b> by
            the CLSU Student Organization Unit.

        </p>
        <p>
            Welcome aboard! We look forward to your active participation and contributions to our organization. Should
            you have any questions or need assistance, do not hesitate to contact us.

        </p>
        <p>
            Thank you for choosing to be a part of </b>{{ $so_name }}</b>.

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
