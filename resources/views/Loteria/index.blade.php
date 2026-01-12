<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Números de la Suerte</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #1e3c72;
            margin-bottom: 10px;
            font-size: 32px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
            font-size: 16px;
        }
        .numeros {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .numero {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            position: relative;
        }
        .numero.mostrar {
            animation: revelar 0.6s ease-out;
        }

        @keyframes revelar {
            0% {
                transform: rotateY(0deg);
            }
            50% {
                transform: rotateY(90deg);
            }
            100% {
                transform: rotateY(0deg);
            }
        }

        @keyframes girar {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .numero.generando {
            animation: girar 0.5s linear infinite;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .info {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 14px;
        }
        .icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🎲 Generador de Números de la Suerte</h1>
    <p class="subtitle">Del 1 al 80 - Sin repetir</p>

    <div class="numeros" id="numeros">
        <div class="numero">?</div>
        <div class="numero">?</div>
        <div class="numero">?</div>
        <div class="numero">?</div>
        <div class="numero">?</div>
    </div>

    <button class="btn" id="btnGenerar">
        <span class="icon">🔄</span>Generar Nuevos Números
    </button>

    <p class="info">
        Haz clic en el botón para generar una nueva combinación
    </p>
</div>

<script>
    const btnGenerar = document.getElementById('btnGenerar');
    const contenedorNumeros = document.getElementById('numeros');

    btnGenerar.addEventListener('click', async () => {
        // Deshabilitar botón
        btnGenerar.disabled = true;
        btnGenerar.textContent = 'Generando...';

        // Agregar animación de carga
        const circulos = contenedorNumeros.querySelectorAll('.numero');
        circulos.forEach(circulo => {
            circulo.textContent = '?';
            circulo.classList.add('generando');
        });

        try {
            // Llamar a la ruta que genera los números
            const response = await fetch('{{ route("suerte.generar") }}');
            const data = await response.json();

            // Esperar un momento para el efecto
            setTimeout(() => {
                // Quitar animación de carga
                circulos.forEach(circulo => {
                    circulo.classList.remove('generando');
                });

                // Mostrar números con animación
                data.numeros.forEach((numero, index) => {
                    setTimeout(() => {
                        circulos[index].textContent = numero;
                        circulos[index].classList.add('mostrar');
                    }, index * 200); // 200ms de delay entre cada número
                });

                // Habilitar botón después de mostrar todos
                setTimeout(() => {
                    btnGenerar.disabled = false;
                    btnGenerar.innerHTML = '<span class="icon">🔄</span>Generar Nuevos Números';
                }, data.numeros.length * 200 + 500);
            }, 1000); // 1 segundo de animación de carga

        } catch (error) {
            console.error('Error:', error);
            btnGenerar.disabled = false;
            btnGenerar.innerHTML = '<span class="icon">🔄</span>Generar Nuevos Números';
            alert('Hubo un error al generar los números');
        }
    });
</script>
</body>
</html>
