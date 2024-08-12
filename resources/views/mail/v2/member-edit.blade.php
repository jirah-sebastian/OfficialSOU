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
            Dear {{ $userName }},
        </p>
        <p>
            We would like to inform you that the details of your membership have been successfully
            updated. Below are the changes made:
        </p>
        <ul>
            @foreach ($changes as $key => $value)
                <li><strong>{{ $key }}:</strong> {{ $value }}</li>
            @endforeach
        </ul>
        <p>
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
