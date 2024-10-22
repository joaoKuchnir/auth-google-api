<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo(a)!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .footer {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Bem-vindo(a)!</h1>
        </div>
        <div class="content">
            <p>Olá, {{ $user->name }}!</p>
            <p>Gostaria de expressar meu agradecimento pela oportunidade de realizar este teste técnico. Ficarei no aguardo do seu feedback 👀</p>                        
        </div>
        <div class="footer">
            <p><strong>João Kuchnir</strong></p>
        </div>
    </div>
</body>

</html>
