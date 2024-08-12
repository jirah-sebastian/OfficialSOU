<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOIS</title>

</head>

<body>
    <main>
        <P>
            Dear {{ $so_pres }},
        </P>
        <p>
            We regret to inform you that your application for an account for <b>"{{ $so_name }}"</b> has been
            reviewed and <b>REJECTED</b>.
        </p>
        <p>
            <b>Reason/s for Rejection:</b>
        </p>
        <p>
            {{ $remark }}
        </p>
        <p>
            If you require further clarification or assistance, please do not hesitate to contact us. Thank you for your
            understanding.
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
