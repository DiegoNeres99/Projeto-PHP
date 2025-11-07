<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('products.index') }}">Minha Loja</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">                
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('customers.index') }}">Clientes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categorias</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Pedidos</a></li>
                
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>