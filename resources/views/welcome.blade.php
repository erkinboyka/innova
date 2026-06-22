<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INNOVA.TJ - Platform of Innovation and Commercialisation</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Three.js & GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <style>
        :root {
            --accent-red: #ff3b3b;
            --accent-green: #00ff66;
            --accent-gold: #ffd700;
            --bg-dark: #050a14;
        }
        
        body {
            background-color: var(--bg-dark);
            color: white;
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            cursor: none; /* Custom cursor later */
        }
        
        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }
        
        .story-section {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            padding: 0 5%;
        }
        
        .content-box {
            max-width: 800px;
            opacity: 0;
            transform: translateY(50px);
            text-align: center;
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 2rem;
            padding: 3rem;
        }

        .text-gradient {
            background: linear-gradient(to right, #fff, #888);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .year-indicator {
            font-size: 8rem;
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            pointer-events: none;
            z-index: -1;
            white-space: nowrap;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 5%;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to bottom, rgba(5,10,20,0.8), transparent);
            backdrop-filter: blur(5px);
        }

        .custom-cursor {
            width: 20px;
            height: 20px;
            border: 2px solid var(--accent-red);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s ease-out;
        }

        .btn-premium {
            background: linear-gradient(45deg, var(--accent-red), #ff7b7b);
            padding: 1rem 2rem;
            border-radius: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 30px rgba(255, 59, 59, 0.3);
        }

        .btn-premium:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 20px 40px rgba(255, 59, 59, 0.5);
        }
    </style>
</head>
<body class="antialiased">
    <div class="custom-cursor" id="cursor"></div>
    <div id="canvas-container"></div>

    <nav>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white flex items-center justify-center rounded-xl rotate-45">
                <span class="text-black font-black text-2xl -rotate-45">I</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black tracking-tighter">INNOVA<span class="text-red-500">.TJ</span></span>
                <span class="text-[8px] uppercase tracking-widest text-gray-400">PICSD Platform</span>
            </div>
        </div>
        <div class="flex gap-4 items-center">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition">
                    {{ App::getLocale() }}
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-4 w-20 rounded-xl border border-white/10 bg-black/90 backdrop-blur p-1 shadow-2xl">
                    <a href="{{ route('lang.switch', 'ru') }}" class="block px-3 py-2 text-[10px] font-black hover:bg-white/10 rounded-lg">RU</a>
                    <a href="{{ route('lang.switch', 'tj') }}" class="block px-3 py-2 text-[10px] font-black hover:bg-white/10 rounded-lg">TJ</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="block px-3 py-2 text-[10px] font-black hover:bg-white/10 rounded-lg">EN</a>
                </div>
            </div>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-premium py-2 text-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2 border border-white/20 rounded-xl hover:bg-white/10 transition text-sm">Вход</a>
                <a href="{{ route('register') }}" class="btn-premium py-2 text-sm">Начать</a>
            @endauth
        </div>
    </nav>

    <!-- Scene 1: 1991 -->
    <section class="story-section" id="scene-1">
        <div class="year-indicator">1991</div>
        <div class="content-box">
            <h2 class="text-6xl font-black mb-6">Из трудностей к развитию</h2>
            <p class="text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto">
                После распада СССР Таджикистан столкнулся с вызовами разрушенной экономики. Это было время испытаний, но и начало пути к суверенитету.
            </p>
        </div>
    </section>

    <!-- Scene 2: Возрождение -->
    <section class="story-section" id="scene-2">
        <div class="year-indicator">Возрождение</div>
        <div class="content-box">
            <h2 class="text-6xl font-black mb-6">Энергия созидания</h2>
            <p class="text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto">
                Ученые, инженеры и студенты стали фундаментом новой истории. Лаборатории ожили, а университеты начали выпускать поколение новаторов.
            </p>
        </div>
    </section>

    <!-- Scene 2.5: Развитие & Образование -->
    <section class="story-section" id="scene-edu">
        <div class="year-indicator">Образование</div>
        <div class="content-box">
            <h2 class="text-6xl font-black mb-6">Знания как основа</h2>
            <p class="text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto">
                Формирование новой образовательной среды. Университеты становятся центрами притяжения талантов.
            </p>
        </div>
    </section>

    <!-- Scene 3: Наука & Инновации -->
    <section class="story-section" id="scene-3">
        <div class="year-indicator">Инновации</div>
        <div class="content-box">
            <h2 class="text-6xl font-black mb-6">Мир технологий</h2>
            <p class="text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto">
                От микрочипов до ИИ. От медицины до космических технологий. Наука Таджикистана выходит на новый глобальный уровень.
            </p>
        </div>
    </section>

    <!-- Scene 3.5: Цифровизация -->
    <section class="story-section" id="scene-digital">
        <div class="year-indicator">Цифровизация</div>
        <div class="content-box">
            <h2 class="text-6xl font-black mb-6">Будущее уже здесь</h2>
            <p class="text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto">
                Единая цифровая экосистема объединяет ученых и бизнес, превращая идеи в национальный продукт.
            </p>
        </div>
    </section>

    <!-- Scene 4: Logo Reveal -->
    <section class="story-section" id="scene-4">
        <div class="content-box">
            <div class="mb-12 inline-block p-8 bg-red-600 rounded-3xl rotate-12 shadow-2xl scale-125">
                <span class="text-8xl font-black">I</span>
            </div>
            <h1 class="text-8xl font-black tracking-tighter mb-4">INNOVA<span class="text-red-500">.TJ</span></h1>
            <p class="text-2xl font-light text-gray-400">Platform of Innovation and Commercialisation of Science Developments (PICSD)</p>
        </div>
    </section>

    <!-- Scene 5: Future -->
    <section class="story-section" id="scene-5">
        <div class="year-indicator">2030+</div>
        <div class="content-box glass-panel">
            <h2 class="text-5xl font-black mb-8">Цифровой Таджикистан 2030</h2>
            <div class="grid grid-cols-2 gap-8 text-left mb-10">
                <div>
                    <span class="block text-red-500 text-3xl font-black mb-2">{{ number_format($stats['projects']) }}+</span>
                    <span class="text-xs uppercase tracking-widest text-gray-500">Разработок</span>
                </div>
                <div>
                    <span class="block text-green-500 text-3xl font-black mb-2">{{ number_format($stats['scientists']) }}+</span>
                    <span class="text-xs uppercase tracking-widest text-gray-500">Ученых</span>
                </div>
            </div>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-premium">Присоединиться</a>
                <a href="#stats" class="px-8 py-4 border border-white/20 rounded-2xl hover:bg-white/10 transition">Подробнее</a>
            </div>
        </div>
    </section>

    <footer class="relative z-10 py-20 px-5 border-t border-white/5 bg-black/50 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-2">
                <h3 class="text-2xl font-black mb-6">INNOVA.TJ</h3>
                <p class="text-gray-400 max-w-sm">Платформа коммерциализации результатов научной и научно-технической деятельности Республики Таджикистан.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Разделы</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white transition">Разработки</a></li>
                    <li><a href="#" class="hover:text-white transition">Ученые</a></li>
                    <li><a href="#" class="hover:text-white transition">Инвесторы</a></li>
                    <li><a href="#" class="hover:text-white transition">Гранты</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Связь</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li>support@innova.tj</li>
                    <li>+992 44 600 00 00</li>
                    <li>г. Душанбе, ул. Академиков Раджабовых 10</li>
                </ul>
            </div>
        </div>
        <div class="mt-20 text-center text-xs text-gray-600 uppercase tracking-[0.4em]">
            &copy; 2026 PICSD REPUBLIC OF TAJIKISTAN. INNOVATE TODAY, TRANSFORM TOMORROW.
        </div>
    </footer>

    <script>
        // Custom Cursor
        const cursor = document.getElementById('cursor');
        document.addEventListener('mousemove', (e) => {
            cursor.style.transform = `translate(${e.clientX - 10}px, ${e.clientY - 10}px)`;
        });

        // Three.js Setup
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);

        camera.position.z = 5;

        // Geometries for scenes
        const particlesCount = 2000;
        const posArray = new Float32Array(particlesCount * 3);
        for(let i=0; i<particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 15;
        }
        const particlesGeometry = new THREE.BufferGeometry();
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.005,
            color: 0xffffff,
            transparent: true,
            opacity: 0.8
        });
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);

        // Scene 2 objects (Revival)
        const cubeGeo = new THREE.BoxGeometry(1, 1, 1);
        const cubeMat = new THREE.MeshPhongMaterial({ color: 0x00ff66, wireframe: true, transparent: true, opacity: 0 });
        const cubes = [];
        for(let i=0; i<20; i++) {
            const cube = new THREE.Mesh(cubeGeo, cubeMat);
            cube.position.set((Math.random()-0.5)*10, (Math.random()-0.5)*10, (Math.random()-0.5)*10);
            cube.rotation.set(Math.random()*Math.PI, Math.random()*Math.PI, 0);
            scene.add(cube);
            cubes.push(cube);
        }

        // Scene 3 objects (Innovation)
        const icoGeo = new THREE.IcosahedronGeometry(0.5, 0);
        const icoMat = new THREE.MeshPhongMaterial({ color: 0xff3b3b, wireframe: true, transparent: true, opacity: 0 });
        const sphereGeo = new THREE.SphereGeometry(0.3, 16, 16);
        const sphereMat = new THREE.MeshPhongMaterial({ color: 0xffd700, transparent: true, opacity: 0 });
        const techGroup = new THREE.Group();
        for(let i=0; i<15; i++) {
            const mesh = new THREE.Mesh(i % 2 === 0 ? icoGeo : sphereGeo, i % 2 === 0 ? icoMat : sphereMat);
            mesh.position.set((Math.random()-0.5)*12, (Math.random()-0.5)*12, (Math.random()-0.5)*12);
            techGroup.add(mesh);
        }
        scene.add(techGroup);

        // Lights
        const light = new THREE.DirectionalLight(0xffffff, 1);
        light.position.set(1, 1, 1);
        scene.add(light);
        scene.add(new THREE.AmbientLight(0x404040));

        // Animation Loop
        function animate() {
            requestAnimationFrame(animate);
            particlesMesh.rotation.y += 0.001;
            particlesMesh.rotation.x += 0.0005;
            
            cubes.forEach(c => {
                c.rotation.x += 0.01;
                c.rotation.y += 0.01;
            });
            
            techGroup.rotation.z += 0.002;
            techGroup.children.forEach(m => {
                m.rotation.y += 0.02;
            });

            renderer.render(scene, camera);
        }
        animate();

        // GSAP Scroll Animations
        gsap.registerPlugin(ScrollTrigger);

        // Reveal content on scroll
        gsap.utils.toArray('.content-box').forEach(box => {
            gsap.to(box, {
                opacity: 1,
                y: 0,
                duration: 1,
                scrollTrigger: {
                    trigger: box,
                    start: "top 80%",
                    end: "top 20%",
                    scrub: 1
                }
            });
        });

        // 3D Scene Transitions
        // Scene 1: Monochrome particles
        gsap.to(particlesMaterial, {
            color: new THREE.Color(0x888888),
            scrollTrigger: { trigger: "#scene-1", scrub: true }
        });

        // Scene 2: Green cubes appearing
        gsap.to(cubeMat, {
            opacity: 0.5,
            scrollTrigger: { trigger: "#scene-2", scrub: true }
        });
        gsap.to(particlesMaterial, {
            color: new THREE.Color(0x00ff66),
            scrollTrigger: { trigger: "#scene-2", scrub: true }
        });

        // Scene 3: Red and Gold objects
        gsap.to(icoMat, {
            opacity: 0.8,
            scrollTrigger: { trigger: "#scene-3", scrub: true }
        });
        gsap.to(sphereMat, {
            opacity: 0.8,
            scrollTrigger: { trigger: "#scene-3", scrub: true }
        });
        gsap.to(camera.position, {
            z: 8,
            scrollTrigger: { trigger: "#scene-3", scrub: true }
        });

        // Scene 4: Explosion of movement
        gsap.to(techGroup.scale, {
            x: 2, y: 2, z: 2,
            scrollTrigger: { trigger: "#scene-4", scrub: true }
        });

        // Resize handler
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>
