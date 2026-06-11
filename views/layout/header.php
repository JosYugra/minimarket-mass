<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión · Tiendas Mass</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Reseteo profesional basado en estándares modernos UI/UX */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8fafc; /* Gris azulado ultra claro muy sutil */
            color: #0f172a; /* Slate oscuro para mejor lectura */
            -webkit-font-smoothing: antialiased;
        }

        /* Títulos estilizados */
        h1 {
            color: #0066B3;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Animación fluida global para botones y enlaces interactivos */
        a, button, select, input {
            transition: all 0.2s ease-in-out !important;
        }

        /* Clases utilitarias que conservamos de tu lógica original */
        .precio {
            font-weight: 600;
            color: #0c1f33;
        }

        .sin-stock {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        /* Micro-interacción: Resaltado suave al pasar el mouse por las filas */
        .fila-tabla:hover {
            background-color: #f8fafc !important;
        }
    </style>
</head>
<body>