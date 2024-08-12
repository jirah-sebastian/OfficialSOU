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
            We hope this message finds you well. We're delighted to share the news that your application for
            <b>"{{ $so_name }}"</b> has been <b>APPROVED</b>.
        </p>
        <p>
            Congratulations! Your unwavering dedication to enhancing our campus community is truly commendable, and
            we're thrilled to officially welcome <b>{{ $so_name }}</b> into our dynamic network of student
            organizations.
        </p>
        <p>
            Below are some key details:
        </p>
        <p>
            Organization Name: {{ $so_name }} <br>
            Approved Date: {{ $date }} <br>
            Contact Person: {{ $so_pres }} <br>
            Contact Email: {{ $email }} <br>
        </p>
        <p>
            Thank you for your enthusiasm and commitment.
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
