<style>
        body {
            background: linear-gradient(135deg,rgb(109, 109, 109) 0%,rgb(179, 188, 204) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .header {
            padding: 2rem;
            text-align: center;
            border-radius: 15px;
            margin-top: 2rem;
            margin-bottom: 2rem;
            max-width: 1140px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .logo {
            font-size: 3rem;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 1rem;
            max-width: 1140px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .container {
            max-width: 1140px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .product-img {
          border-radius: 10px;
          width: 100%;
          height: 100%;
          max-height: 300px;
          object-fit: cover;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
          margin-bottom: 1rem;
        }

        .product-img:hover {
          transform: scale(1.05) rotate(-2deg);
          box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
          cursor: pointer;
        }
        
    </style>
<body>
    <div class="header">
        <div class="logo">¡Bienvenido a tu Aplicación de compras!</div>
    </div>
    
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <p class="lead">
                    "Simplifica tu vida, organiza fácilmente tus compras de productos de alimentos, higiene y artículos para el hogar, mantén todo bajo control especialmente para hacer tu día a día más sencillo y eficiente."
                </p>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-12 text-center mb-4">
                <h2 class="text-uppercase fw-bold">Categorias de Productos</h2>
                <p class="text-muted">Organiza tus categorias de compras de una forma mas util y ordenada para ti.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="https://thumbs.dreamstime.com/b/accesorios-para-el-hogar-y-productos-en-centro-comercial-vista-de-los-la-sala-estar-tienda-moda-minorista-sof%C3%A1-con-mesa-almohadas-245100114.jpg" class="card-img-top product-img" alt="Hogar">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Productos para el hogar</h5>
                        <p class="card-text text-muted">Prioriza tus articulos para el hogar de una mejor forma y eficiente.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="https://concepto.de/wp-content/uploads/2015/03/alimentos-e1549655531380.jpg" class="card-img-top product-img" alt="Alimentos">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Alimentos</h5>
                        <p class="card-text text-muted">Prioriza tus alimentos de una mejor forma y eficiente para una buena alimentación.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="https://atriainnovation.com/uploads/2023/11/Portada_3.jpg" class="card-img-top product-img" alt="Higiene">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Productos de higiene</h5>
                        <p class="card-text text-muted">Prioriza tus articulos de higiene de una mejor forma y eficiente.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-6 mx-auto text-center">
                <h2 class="mb-4 text-uppercase fw-bold">Aspectos Importantes</h2><br>
                <p><strong>Organiza:</strong>  distribuye y busca los mejores productos para una mejor compra.</p>
                <p><strong>Prioriza:</strong> determina la importancia o urgencia de adquirir ciertos artículos sobre otros.</p>
                <p><strong>Planifica:</strong> identifica necesidades específicas para garantizar una compra ordenada y eficiente.</p>
                <a href="/app01_macs/productos" class="btn btn-primary mt-3">Conoce tu aplicación</a>
            </div>
        </div>
    </div>
        <script src="build/js/inicio.js"></script>
  </body>


