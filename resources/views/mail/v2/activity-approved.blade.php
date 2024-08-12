<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLSU-SOU</title>

</head>

<body>
    {{-- <header>
        <img src="{{ $message->embedData(file_get_contents(public_path('assets/img/sou/logo-white.png')), 'Logo') }}" alt="Logo">
        <h1>CLSU Student Organization Unit</h1>
        <p></p>
    </header> --}}
    <main>
        <p>
            Dear {{ $so_pres }},
        </p>
        <p>
            We are pleased to inform you that your requested activity entitled "<b>{{ $activityTitle }}</b>" for
            <b>{{ $so_name }}</b> has been <b>APPROVED</b>. <br>If you
            need any further assistance, please feel free to reach out. <br><br>Thank you.
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
