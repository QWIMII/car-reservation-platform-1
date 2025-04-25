<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение бронирования - MEOWVEST Автопарк</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <?php include TEMPLATE_PATH . '/partials/header.php'; ?>
    
    <main class="container mx-auto px-4 py-16">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <svg class="w-20 h-20 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                
                <h1 class="text-3xl font-playfair font-bold mb-4">Бронирование подтверждено</h1>
                <p class="text-gray-600">Ваше бронирование успешно создано и ожидает подтверждения</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Детали бронирования</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Номер бронирования</h3>
                            <p class="text-lg font-medium">#<?= str_pad($reservation['id'], 6, '0', STR_PAD_LEFT) ?></p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Статус</h3>
                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Ожидает подтверждения
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Даты аренды</h3>
                            <p class="font-medium"><?= date('d.m.Y', strtotime($reservation['start_date'])) ?> — <?= date('d.m.Y', strtotime($reservation['end_date'])) ?></p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Общая стоимость</h3>
                            <p class="text-lg font-bold text-primary"><?= number_format($reservation['total_price'], 0, ',', ' ') ?> ₽</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center mb-4">
                            <img src="<?= $car['image_url'] ?>" alt="<?= $car['name'] ?>" class="w-20 h-20 object-cover rounded-md mr-4">
                            <div>
                                <h3 class="font-bold"><?= $car['name'] ?></h3>
                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                    <span><?= $car['year'] ?></span>
                                    <span class="mx-2">•</span>
                                    <span><?= $car['transmission'] ?></span>
                                    <span class="mx-2">•</span>
                                    <span><?= $car['engine_power'] ?> л.с.</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="font-semibold">Место получения:</div>
                                <p class="text-gray-700"><?= $reservation['pickup_location'] ?></p>
                            </div>
                            
                            <div>
                                <div class="font-semibold">Место возврата:</div>
                                <p class="text-gray-700"><?= $reservation['return_location'] ?></p>
                            </div>
                            
                            <?php if (!empty($reservation['options'])): ?>
                                <div class="md:col-span-2">
                                    <div class="font-semibold mb-1">Дополнительные опции:</div>
                                    <ul class="text-gray-700">
                                        <?php foreach (json_decode($reservation['options'], true) as $key => $value): ?>
                                            <?php if ($value): ?>
                                                <li>• <?= $options[$key]['name'] ?> (+<?= number_format($options[$key]['price'], 0, ',', ' ') ?> ₽/день)</li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($reservation['special_requests'])): ?>
                                <div class="md:col-span-2">
                                    <div class="font-semibold mb-1">Особые пожелания:</div>
                                    <p class="text-gray-700"><?= $reservation['special_requests'] ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Что дальше?</h2>
                    
                    <ol class="space-y-4">
                        <li class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-primary text-white font-bold">1</div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium">Ожидайте подтверждения</p>
                                <p class="text-gray-600 text-sm">Наши менеджеры свяжутся с вами в течение 24 часов для подтверждения бронирования.</p>
                            </div>
                        </li>
                        
                        <li class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-primary text-white font-bold">2</div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium">Подготовьте документы</p>
                                <p class="text-gray-600 text-sm">Для получения автомобиля вам потребуются паспорт и водительское удостоверение.</p>
                            </div>
                        </li>
                        
                        <li class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-primary text-white font-bold">3</div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium">Получите автомобиль</p>
                                <p class="text-gray-600 text-sm">В выбранную дату и время прибудьте в место получения автомобиля.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
            
            <div class="text-center">
                <a href="/profile/reservations" class="inline-flex items-center text-primary hover:text-primary-dark transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Перейти к моим бронированиям
                </a>
            </div>
        </div>
    </main>
    
    <?php include TEMPLATE_PATH . '/partials/footer.php'; ?>
</body>
</html>
