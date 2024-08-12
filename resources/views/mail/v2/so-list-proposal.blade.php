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
            Dear CLSU Student Organization Unit,
        </p>
        <p>
            This is to inform you that a new registration for an organization has been received.
        </p>
        <p>
            Below are some key details:
        </p>
        <p>
            <b>Organization Name:</b> {{ $so_name }}<br>
            <b>Contact Person:</b> {{ $so_pres }}<br>
            <b>Contact Email:</b> {{ $so_contact }}
        </p>
        <p>
            Thank you for your attention to this matter.
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
