<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="/" class="flex items-center">
                <img src="/logo-meowvest.svg" alt="MEOWVEST Автопарк" class="h-10">
                <span class="ml-2 text-xl font-bold">АВТОПАРК</span>
            </a>
            
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-primary transition">Главная</a>
                <a href="/catalog" class="text-gray-700 hover:text-primary transition">Каталог</a>
                <a href="/about" class="text-gray-700 hover:text-primary transition">О нас</a>
                <a href="/contact" class="text-gray-700 hover:text-primary transition">Контакты</a>
            </nav>
            
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="relative group">
                        <button class="flex items-center text-gray-700 hover:text-primary transition">
                            <span class="mr-1"><?= $_SESSION['user_name'] ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div class="absolute right-0 z-10 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Личный кабинет</a>
                            <a href="/profile/reservations" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Мои бронирования</a>
                            
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Админ-панель</a>
                            <?php endif; ?>
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Выйти</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-gray-700 hover:text-primary transition">Войти</a>
                    <a href="/register" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
