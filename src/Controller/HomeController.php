<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ProductoRepository $repo_producto;
    private UsuarioRepository $repo_usuario;

    public function __construct(EntityManagerInterface $entityManager, ProductoRepository $repo_producto, UsuarioRepository $repo_usuario)
    {
        $this->entityManager = $entityManager;
        $this->repo_producto = $repo_producto;
        $this->repo_usuario = $repo_usuario;
    }
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // Obtener todas las categorías únicas de los productos
        $categorias = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.categoria')
            ->from(Producto::class, 'p')
            ->getQuery()
            ->getResult();

        $marcas = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.marca')
            ->from(Producto::class, 'p')
            ->getQuery()
            ->getResult();


        $productos = [];
        $productos_marca = [];

        if (count($categorias) > 0) {
            // Obtener los productos de la primera categoría por defecto
            $productos = $this->entityManager->getRepository(Producto::class)
                ->findBy(['categoria' => $categorias[0]['categoria']]);
        }

        if (count($marcas) > 0) {
            // Obtener los productos de la primera marca por defecto
            $productos_marca = $this->entityManager->getRepository(Producto::class)
                ->findBy(['marca' => $marcas[0]['marca']]);
        }

        return $this->render('home/home.html.twig', [
            'categorias' => $categorias,
            'productos' => $productos,
            'marcas' => $marcas,
            'productos_marca' => $productos_marca
        ]);
    }

    #[Route('/productos/{categoria}', name: 'productos_por_categoria', methods: ['GET'])]
    public function productosPorCategoria(string $categoria): Response
    {
        // Obtener los productos de la categoría seleccionada
        $productos = $this->entityManager->getRepository(Producto::class)
            ->findBy(['categoria' => $categoria]);

        // Preparar la respuesta JSON con los productos
        $productosArray = [];
        foreach ($productos as $producto) {
            $productosArray[] = [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'precio' => $producto->getPrecio(),
            ];
        }

        // Devolver la respuesta JSON
        return $this->json($productosArray);
    }

    #[Route('/producto/{id}', name: 'producto')]
    public function producto(EntityManagerInterface $em, int $id): Response
    {
        $producto = $em->getRepository(Producto::class)->find($id);
        return $this->render('home/producto.html.twig', [
            'producto' => $producto
        ]);
    }

    #[Route('/categorias', name: 'categorias', methods: ['GET'])]
    public function categorias(): Response
    {
        $categorias = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.categoria')
            ->from(Producto::class, 'p')
            ->getQuery()
            ->getResult();
        // Devolver la respuesta JSON
        return $this->json($categorias);
    }
    #[Route('/marcas', name: 'marcas', methods: ['GET'])]
    public function marcas(): Response
    {
        $marcas = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.marca')
            ->from(Producto::class, 'p')
            ->getQuery()
            ->getResult();
        // Devolver la respuesta JSON
        return $this->json($marcas);
    }

    #[Route('/carrito', name: 'carrito', methods: ['GET'])]
    public function carrito(SessionInterface $session): Response
    {
        if (!$session->has('carrito')) {
            $session->set('carrito', []);
        }

        return $this->json($session->get('carrito'));
    }

    #[Route('/carrito_agregar', name: 'carrito_agregar', methods: ['POST'])]
    public function carrito_agregar(Request $request, SessionInterface $session): Response
    {
        if (!$session->has('carrito')) {
            $session->set('carrito', []);
        }

        $producto = [
            'id' => $request->request->get('id'),
            'nombre' => $request->request->get('nombre'),
            'precio' => $request->request->get('precio'),
        ];

        // Add the product to the cart
        $carrito = $session->get('carrito');
        $carrito[] = $producto;
        $session->set('carrito', $carrito);

        return $this->json($carrito);
    }

    #[Route('/carrito_eliminar', name: 'carrito_eliminar', methods: ['POST'])]
    public function carrito_eliminar(Request $request, SessionInterface $session): Response
    {
        $id = $request->request->get('id');
        $carrito = $session->get('carrito');
        for ($i = 0; $i < count($carrito); $i++) {
            if ($carrito[$i]['id'] == $id) {
                array_splice($carrito, $i, 1);
                break;
            }
        }
        $session->set('carrito', $carrito);
        return $this->json($carrito);
    }


    #[Route('/productos/categoria/{categoria}', name: 'productos_categoria', methods: ['GET'])]
    public function productosCategoria(string $categoria, ProductoRepository $productoRepository): Response
    {
        // Usar el método findByCategoria del repositorio para obtener los productos
        $productos = $productoRepository->findByCategoria($categoria);

        return $this->render('parciales/productos_filtrados.html.twig', [
            'products' => $productos,
            'filterName' => ucfirst($categoria), // Capitalizamos la primera letra para la presentación
        ]);
    }

    #[Route('/productos/marca/{marca}', name: 'productos_por_marca', methods: ['GET'])]
    public function productosPorMarca(string $marca, ProductoRepository $productoRepository): Response
    {
        // Usar el método findByMarca del repositorio para obtener los productos
        $productos = $productoRepository->findByMarca($marca);

        return $this->render('parciales/productos_filtrados.html.twig', [
            'products' => $productos,
            'filterName' => ucfirst($marca), // Capitalizamos la primera letra para la presentación
        ]);
    }
    #[Route('/administracion', name: 'administracion')]
    public function administracion(): Response
    {
        // Obtener todas las categorías únicas de los productos
        $categorias = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.categoria')
            ->from(Producto::class, 'p')
            ->getQuery()
            ->getResult();

        $marcas = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.marca')
            ->from(Producto::class, 'p')
            ->getQuery()
            ->getResult();

        return $this->render('perfil/administracion.html.twig', [
            'categorias' => $categorias,
            'marcas' => $marcas
        ]);
    }
    #[Route('/nuevoProducto', name: 'nuevoProducto')]
    public function nuevoProducto(): Response
    {
        $producto = new Producto();
        $producto->setNombre($_POST['nombre']);
        $producto->setDescripcion($_POST['descripcion']);
        $producto->setPrecio($_POST['precio']);
        //$producto->setDescuento($_POST['descuento']);
        $producto->setCategoria($_POST['categoria']);
        $producto->setMarca($_POST['marca']);
        $producto->setColor($_POST['color']);
        $producto->setImagen("/uploads/productos/" . $_FILES['foto']['name']);
        $producto->setStock($_POST['stock']);
        //$producto->setEstado($_POST['estado']);

        $this->entityManager->persist($producto);
        $this->entityManager->flush();
        if (isset($_FILES['foto']) && strlen($_FILES['foto']['name'])) {
            $this->guardarArchivo($_FILES['foto']);
        }
        return $this->redirectToRoute('home');
    }

    private function guardarArchivo($file)
    {
        $filesystem = new Filesystem();
        $folderPath = $this->getParameter('kernel.project_dir') . '/public/uploads/productos/';
        if (!$filesystem->exists($folderPath)) {
            $filesystem->mkdir($folderPath, 0777, true);
        }
        $filePath = $folderPath . $file['name'];
        move_uploaded_file($file['tmp_name'], $filePath);
    }

    #[Route('/buscador', name: 'buscador')]
    public function buscador(): Response
    {
        $parametro = strtolower($_POST['titulo']);

        $productos = $this->buscarProducto($parametro);

        return $this->render('home/producto.html.twig', [
            'productos' => $productos
        ]);
    }

    private function buscarProducto($parametro)
    {
        return $this->repo_producto->createQueryBuilder('p')
            ->andWhere("LOWER(p.nombre) LIKE '%" . $parametro . "%'")
            ->orWhere("LOWER(p.categoria) LIKE '%" . $parametro . "%'")
            ->orWhere("LOWER(p.marca) LIKE '%" . $parametro . "%'")
            ->getQuery()->getResult();
    }
    private function buscarUsuario($parametro)
    {
        return $this->repo_usuario->createQueryBuilder('u')
            ->andWhere("LOWER(u.email) LIKE '%" . $parametro . "%'")
            ->getQuery()->getResult();
    }


    #[Route('/buscarProducto', name: 'buscarProducto', methods: ['POST'])]
    public function buscarProductos(Request $request): Response
    {
        $producto = strtolower($request->request->get('producto'));
        $lista = $this->buscarProducto($producto);
        return $this->json($lista);
    }


    #[Route('/buscarUsuario', name: 'buscarUsuario', methods: ['POST'])]
    public function buscarUsuarios(Request $request): Response
    {
        $usuario = strtolower($request->request->get('usuario'));
        $lista = $this->buscarUsuario($usuario);
        return $this->json($lista);
    }

    #[Route('/eliminarUsuario', name: 'eliminarUsuario', methods: ['POST'])]
    public function eliminarUsuario(Request $request): Response
    {
        $id = $request->request->get('id');
        $user = $this->repo_usuario->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this->json($user);
    }

    #[Route('/eliminarProducto', name: 'eliminarProducto', methods: ['POST'])]
    public function eliminarProducto(Request $request, SessionInterface $session): Response
    {
        $id = $request->request->get('id');
        $product = $this->repo_producto->find($id);
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        return $this->json($product);
    }
}
