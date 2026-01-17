<?php
$db = Database::getConnection();

// Default to first product if no ID provided
$product_id = $_GET['id'] ?? null;
if ($product_id) {
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
} else {
    // Fallback: Get the first product
    $product = $db->query("SELECT * FROM products LIMIT 1")->fetch();
}

$all_products = $db->query("SELECT * FROM products")->fetchAll();
?>

<div class="flex h-[calc(100vh-64px)] bg-gray-100 overflow-hidden">
    <!-- Sidebar Controls -->
    <div class="w-80 bg-white shadow-xl z-10 flex flex-col h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 font-serif">3D Visualizer</h2>
            <p class="text-gray-500 text-sm mt-1">Customize your view</p>
        </div>

        <div class="p-6 space-y-8 flex-grow">
            <!-- Product Info -->
            <div>
                <h3 class="font-bold text-gray-900 mb-2">Selected Item</h3>
                <div class="bg-gray-50 rounded-lg p-3 flex items-center shadow-inner">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>"
                        class="w-12 h-12 rounded object-cover mr-3 bg-white shadow-sm">
                    <div>
                        <p class="font-medium text-sm text-gray-800 line-clamp-1">
                            <?= htmlspecialchars($product['name']) ?>
                        </p>
                        <p class="text-xs text-indigo-600 font-bold">$
                            <?= number_format($product['price'], 2) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div>
                <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Environment</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-2">Background Color</label>
                        <div class="flex space-x-2">
                            <button onclick="changeBg('#f3f4f6')"
                                class="w-8 h-8 rounded-full bg-gray-100 border-2 border-transparent hover:border-indigo-500 focus:border-indigo-500 outline-none transition"></button>
                            <button onclick="changeBg('#1c1917')"
                                class="w-8 h-8 rounded-full bg-stone-900 border-2 border-transparent hover:border-indigo-500 focus:border-indigo-500 outline-none transition"></button>
                            <button onclick="changeBg('#fff7ed')"
                                class="w-8 h-8 rounded-full bg-orange-50 border-2 border-transparent hover:border-indigo-500 focus:border-indigo-500 outline-none transition"></button>
                            <button onclick="changeBg('#e0e7ff')"
                                class="w-8 h-8 rounded-full bg-indigo-50 border-2 border-transparent hover:border-indigo-500 focus:border-indigo-500 outline-none transition"></button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Auto Rotate</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="autoRotateCheck" checked class="sr-only peer"
                                onchange="toggleAutoRotate()">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                        </label>
                    </div>


                </div>
            </div>

            <!-- Other Items -->
            <div>
                <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Select Item</h3>
                <div class="grid grid-cols-4 gap-2">
                    <?php foreach ($all_products as $p): ?>
                        <a href="index.php?page=visualize&id=<?= $p['id'] ?>"
                            class="block relative group aspect-square rounded-md overflow-hidden border-2 <?= ($p['id'] == $product['id']) ? 'border-indigo-600' : 'border-transparent hover:border-gray-300' ?> transition">
                            <img src="<?= htmlspecialchars($p['image_url']) ?>" class="w-full h-full object-cover">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <a href="index.php?page=product&id=<?= $product['id'] ?>"
                class="block w-full bg-stone-900 text-white text-center py-3 rounded-lg font-bold hover:bg-stone-800 transition shadow-lg">View
                Details</a>
        </div>
    </div>

    <!-- 3D Canvas -->
    <div id="canvas-container" class="flex-grow relative bg-gray-100 cursor-move">
        <div class="absolute top-6 right-6 z-10 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm">
            <p class="text-xs font-semibold text-gray-600">Interactive 3D View • Drag to Rotate • Scroll to Zoom</p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://unpkg.com/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<script>
    const container = document.getElementById('canvas-container');
    const imageUrl = "<?= htmlspecialchars($product['image_url']) ?>";

    // Scene setup
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf3f4f6); // Default background matching gray-100

    const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.z = 2.5;

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);

    // Controls
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 2.0;

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(5, 5, 5);
    directionalLight.castShadow = true;
    scene.add(directionalLight);

    const pointLight = new THREE.PointLight(0xffffff, 0.5);
    pointLight.position.set(-5, -5, 5);
    scene.add(pointLight);

    // Gift Group (Now just the 2D Plane)
    const giftGroup = new THREE.Group();
    scene.add(giftGroup);

    const textureLoader = new THREE.TextureLoader();
    textureLoader.load(imageUrl, function (texture) {

        // Get image dimensions
        const image = texture.image;
        const width = image.width;
        const height = image.height;

        // Calculate aspect ratio
        const aspect = width / height;

        // Base size logic: Fit within a 2x2 area roughly
        let planeWidth, planeHeight;

        if (aspect >= 1) {
            // Landscape or Square
            planeWidth = 2;
            planeHeight = 2 / aspect;
        } else {
            // Portrait
            planeHeight = 2;
            planeWidth = 2 * aspect;
        }

        // Geometry: Simple Plane for the cutout
        const geometry = new THREE.PlaneGeometry(planeWidth, planeHeight);

        // Access texture data to guess aspect if needed, but we did that above.
        // Shader Material for Chroma Key (removing white background)
        const material = new THREE.ShaderMaterial({
            uniforms: {
                textureMap: { value: texture },
                color: { value: new THREE.Color(0xffffff) }, // Base transform color if needed
                keyColor: { value: new THREE.Color(0xffffff) }, // Color to remove (White)
                similarity: { value: 0.15 }, // Threshold
                smoothness: { value: 0.05 }  // Edge smoothing
            },
            vertexShader: `
                varying vec2 vUv;
                void main() {
                    vUv = uv;
                    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
                }
            `,
            fragmentShader: `
                uniform sampler2D textureMap;
                uniform vec3 keyColor;
                uniform float similarity;
                uniform float smoothness;
                varying vec2 vUv;

                void main() {
                    vec4 texColor = texture2D(textureMap, vUv);
                    
                    // Calculate difference from key color
                    float diff = length(texColor.rgb - keyColor);
                    
                    // Alpha based on difference
                    float alpha = smoothstep(similarity, similarity + smoothness, diff);
                    
                    // Output color with calculated alpha
                    gl_FragColor = vec4(texColor.rgb, texColor.a * alpha);
                    
                    // Simple alpha discard for depth sorting
                    if (alpha < 0.1) discard;
                }
            `,
            side: THREE.DoubleSide,
            transparent: true
        });

        const cutout = new THREE.Mesh(geometry, material);
        cutout.castShadow = true;
        cutout.receiveShadow = true;

        giftGroup.add(cutout);

    }, undefined, function (err) {
        console.error('An error happened with the texture.');
    });

    // Handle Window Resize
    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });

    // Animation Loop
    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }
    animate();

    // UI Functions
    function changeBg(color) {
        scene.background = new THREE.Color(color);
    }

    function toggleAutoRotate() {
        controls.autoRotate = document.getElementById('autoRotateCheck').checked;
    }
</script>