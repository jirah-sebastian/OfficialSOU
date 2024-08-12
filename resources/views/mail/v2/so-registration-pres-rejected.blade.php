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
        Dear {{$applicant_name}},
    </p>
    <p>
        We regret to inform you that your membership application for {{$so_name}} has been </b>REJECTED</b>.

    </p>
    <p>
      <b>Reason(s) for rejection:</b><br>
        {{$remark}}

    </p>
    <p>
        If you have any questions or need further clarification, please feel free to reach out to us.

    </p>
    <p>
        Thank you for your understanding.
    </p>
    <p>
        Best regards,<br>
        {{$so_pres}} <br>
        President of
        {{$so_name}}
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
    background-color: green; /* For browsers that do not support gradients */
      /* background-image: radial-gradient(#e5ff00, green); */
  }
  header img {
    max-width: 100px; /* Adjust the maximum width of the logo */
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
